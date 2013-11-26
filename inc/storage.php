<?php

class Storage {
  
  private $url;
  private $switch_time;
  
  public function __construct(){
    $this->url = Config::$url;
    $this->switch_time = Config::$switch_time;
  }
  
  private function makeUrl($grade, $date){
    return(str_replace(
      array('{grade}', '{d}', '{m}', '{y}'),
      array($grade, $date->format('d'), $date->format('m'), $date->format('y')),
      $this->url
    ));
  }
  
  private function filterPlanHtml($html, $remove_header = false){
    $html = str_replace('&nbsp;', '', $html);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    $vp_table = null;
    $tables = $doc->getElementsByTagName('table');
    foreach($tables as $table){
      if($table->getAttribute('border') == 3){
        $vp_table = $table;
        break;
      }
    }

    $vp_table->setAttribute('border', 0);
    if(!$vp_table) return $html;
    if($remove_header){
      $vp_table->removeChild($vp_table->firstChild);
    }else{
      $vp_table->firstChild->setAttribute('class', 'vplan_th');
    }
    $table_html = preg_replace("/<[\/]{0,1}(font)[^><]*>/", '', $vp_table->ownerDocument->saveXML($vp_table));
    $table_html = str_replace('<td align="center"/>', '<td align="center"></td>', $table_html);
    return($table_html);
  }
  
  public function getPlan($grade, $date){
    $vp = new VPlan($date);
    $vp->url = $this->makeUrl($grade, $date);
    if (!function_exists('curl_init')){ 
        die('cURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $vp->url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    $html = curl_exec($ch);
    $info = curl_getinfo($ch);

    if($info['http_code'] == 0) $info['http_code'] = "0";
    if($info['http_code'] >= 300 || $info['http_code'] == 0){
      $vp = $info['http_code'];
    }else{
      $vp->html = $this->filterPlanHtml($html);
      $vp->grade = $grade;
    }
    curl_close($ch);
    return $vp;
  }
  
  public function getLatestPlan($grade, $date_only = false){
    $switch = date('G', time()) < $this->switch_time;
    $date = ($switch)? new DateTime('today') : new DateTime('tomorrow');
    if($date->format('N')>5){
      $date = new DateTime('next monday');
    }
    if($date_only) return($date);
    return($this->getPlan($grade, $date));
  }

  private function getInnerHtml($node) {
    $innerHTML= '';
    $children = $node->childNodes;
    foreach ($children as $child) {
      $innerHTML .= $child->ownerDocument->saveXML( $child );
    }
  
    return $innerHTML;
  }

}
