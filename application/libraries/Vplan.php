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
  }
  
  public function buildUrl($date, $grade = ''){
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
  
  public function downloadPlan($date, $grade = ''){
    $url = $this->buildUrl($date, $grade);
    $xml = new DOMDocument();
    @$xml->loadHTMLFile($url);
    if(!$xml->textContent) return false;
    return($xml);
  }
  
  public function analyzeIndex($html){
    if($html){
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
      
      return($grades);
    }else return(false);
  }
  
  public function analyzeSingle($html){
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
  
  function updateDate($date){
    $index = $this->downloadPlan($date);
    $grades = $this->analyzeIndex($index);
    
    if($grades){
      $substs = array();
      foreach($grades as $grade){
        $single = $this->downloadPlan($date, $grade);
        $substs[$grade] = $this->analyzeSingle($single);
      }
      return($substs);
    }else return(false);
  }
  
  function updateAll(){
    $today = new DateTime('today');
    $today_data = $this->updateDate($today);
    if($today_data){
      $this->insertData($today_data, $today);
    }else die('Keine Eintr&auml;ge f&uuml;r ' . $today->format('d.m.Y'));
  }
  
  function insertData($grades, $date){
    $this->ci =& get_instance();
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
  }
  
}

/* End of file Vplan.php */
/* Location: ./system/application/libraries/Vplan.php */