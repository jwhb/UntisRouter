<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vplan {
  
  private $index_url;
  private $single_url;
  
  private $headers = array(
  	'grade',
    'time',
    'teacher',
    'class',
    'room',
    'type',
    'class_old',
    'room_old',
    'subst_from',
    'subst_to',
    'info'
  );
  
  public function __construct($urls){
    $this->index_url = $urls['index'];
    $this->single_url = $urls['single'];
    
    $this->ci =& get_instance();
    $this->ci->load->model('substtext_model', 'substtext');
    $this->ci->load->helper('file');
  }
  
  private function getNodeHtml($node) {
    $html = '';
    $children = $node->childNodes;
    foreach($children as $child){
      $tmp_doc = new DOMDocument();
      $tmp_doc->appendChild($tmp_doc->importNode($child, true));
      $html .= $tmp_doc->saveHTML();
    }
    return $html;
  }
  
  private function buildUrl($date, $grade = ''){
    $grade = str_replace('-', '_', $grade);
    $url_format = (strlen($grade) == 0)? $this->index_url : $this->single_url;
    $search = array('{dd}', '{mm}', '{yy}');
    $replace = array($date->format('d'), $date->format('m'), $date->format('y'));

    if(strlen($grade) > 0){
    	$search[] = '{grade}';
    	$replace[] = $grade;
    }
    
    $url = str_replace($search, $replace, $url_format);
    return (is_array($url))? $url[0] : $url;
  }
  
  private function downloadPlan($date, $grade = ''){
    $url = $this->buildUrl($date, $grade);
    $html = file_get_contents($url);
    $xml = new DOMDocument();
    @$xml->loadHTML($html);
    if(!$xml->textContent) return false;
    return($xml);
  }
  
  private function analyzeIndex($html){
    if($html){
      
      //Gather grades from table
      $table = null;
      $i = -1;
      foreach($html->getElementsByTagName('table') as $cur_table){
        $i++;
        if($i == 1){
          $table = $cur_table;
        }
      }
      
      $grades = array();
      
      foreach($table->getElementsByTagName('a') as $cell){
        $grades[] = $cell->nodeValue;
      }
      
      //Gather substitution text
      $substtext = '';
      foreach($html->getElementsByTagName('font') as $text_tag){
        if($text_tag->getAttribute('size') == 5){
          $substtext = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", '', $this->getNodeHtml($text_tag));
          $substtext = trim(str_replace('<br>', "\n", $substtext));
          $substtext = str_replace("\n\n", "\n", $substtext);
          $substtext = str_replace("\n\n", "\n", $substtext);
          $substtext = str_replace("\n", '<br>', $substtext);
        }
      }     
      
      return(array('grades' => $grades, 'substtext' => $substtext));
    }else return(false);
  }
  
  private function analyzeSingle($html){
    if($html){
      $table = null;
      $i = -1;
      foreach($html->getElementsByTagName('table') as $cur_table){
        $i++;
        if($i == 1){
          $table = $cur_table;
        }
      }
      
      $substs = array();

      if($table != null){
      $i = -1;
        foreach($table->getElementsByTagName('tr') as $subst_row){
          $i++;
          if($i > 0){
            $subst = array();
            $j = -1;
            foreach($subst_row->getElementsByTagName('td') as $subst_cell){
              $j++;
              $text = $subst_cell->textContent;
              $text = trim(htmlspecialchars(utf8_decode($text)));
              
              if(isset($this->headers[$j])){ //Try to get cell header text from array
                $subst[$this->headers[$j]] = $text;
              }else{
                $subst[] = $text;
              }
            }
            $substs[]  = $subst; //Add current row to substitutions array
          }
        }
      }
      return($substs);
    }else return(false);
  }
  
  public function updateDate($date){
    $index = $this->downloadPlan($date);
    $index_info = $this->analyzeIndex($index);
    
    $substtext = (isset($index_info['substtext']))? $index_info['substtext'] : '';
    $this->updateSubstText($substtext, $date);
    $grades = (isset($index_info['grades']))? $index_info['grades'] : array();
    
    if($grades){
      $substs = array();
      foreach($grades as $grade){
        $single = $this->downloadPlan($date, $grade);
        $substs[$grade] = $this->analyzeSingle($single);
      }
      return($substs);
    }else return(false);
  }
  
  public function updateAll(){
    $today = new DateTime('today');
    $today_data = $this->updateDate($today);
    $today_count = 0;
    if($today_data) foreach($today_data as $grade){
      $today_count += sizeof($grade);
    }
    if($today_data){
      $this->insertData($today_data, $today);
    }
    
    $tmrw = new DateTime('tomorrow');
    if($tmrw->format('N') > 5) $tmrw = new DateTime('next monday');
    $tmrw_data = $this->updateDate($tmrw);
    $tmrw_count = 0;
    if($tmrw_data) foreach($tmrw_data as $grade){
      $tmrw_count += sizeof($grade);
    }
    if($tmrw_data){
      $this->insertData($tmrw_data, $tmrw);
    }
    
    $this->exportJson();
    
    return(array($today_count, $tmrw_count));
  }
  
  private function insertData($grades, $date){
    $this->ci->load->model('Substitution_model', 'substitutions', TRUE);
    $old_ids = $this->ci->substitutions->delete_many_by_many(array('grade' => array_keys($grades), 'date' => $date->format('Y-m-d')));
    
    foreach($grades as $grade_name=>$grade){
      if($grade){
        foreach($grade as $entry){
          $data = array(
          	  'grade' => $grade_name,
              'date' => $date->format('Y-m-d'),
              'time' => $entry['time'],
              'teacher' => $entry['teacher'],
              'class' => $entry['class'],
              'room' => $entry['room'],
              'type' => $entry['type'],
              'room_old' => $entry['room_old'],
              'info_text' => $entry['info']
          );
          if(sizeof($old_ids) > 0) $data['id'] = array_shift($old_ids);
          $this->ci->substitutions->insert($data);
        }
      }
    }
    
    $this->ci->substitutions->delete_empty();
  }
  
  private function updateSubstText($texts, $date){
    if(!is_array($texts)) $texts = array($texts);
    $ids = $this->ci->substtext->delete_many_by_many(array('date' => $date->format('Y-m-d')));
    foreach($texts as $text){
      $values = array('date' => $date->format('Y-m-d'), 'text' => $text);
      if(sizeof($ids) > 0) $values['id'] = array_shift($ids);
      $this->ci->substtext->insert($values);
    }
  }
  
  public function exportJson(){
    $all_ahead = $this->ci->substitutions->get_all_ahead();
    write_file('assets/export/vp_all_ahead.json', json_encode($all_ahead));
  }
  
}

/* End of file Vplan.php */
/* Location: ./system/application/libraries/Vplan.php */