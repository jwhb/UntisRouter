<?php

use Rain\MyTPL;
class Router {
  
  private $baseurl;
  private $dir;
  private $domain;
  private $storage;
  
  public function __construct($request){
    $this->storage = new Storage();
    
    //Script directory on webhost
    $this->dir = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

    //Domain/host name
    $this->domain = 'http://' . $_SERVER['HTTP_HOST'];
    
    //Base URL to script
    $this->baseurl = $this->domain . $this->dir;
    
    $this->dispatch(substr($request, strlen($this->dir)));
  }
  
  public function redirect($url, $html_redir = true, $exit = true){
    if($html_redir){?>
      <!DOCTYPE html>
      <html>
      <head>
        <meta http-equiv="refresh" content="0; url=<?php echo $url; ?>">
      </head>    
      </html><?php
    }else{
      header('HTTP/1.1 302 Moved Temporarily');
      header('Location: ' . $url);
    }
    if($exit) exit();
  }
  
  public function makeLocalUrl($grade, $date){
    return($this->baseurl . str_replace(
      array('{g}', '{d}', '{m}', '{y}'),
      array($grade, $date->format('d'), $date->format('m'), $date->format('Y')),
      '{g}/{d}/{m}/{y}'
    ));
  }
  
  public function makeDate($d, $m, $y){
    $date = new DateTime("$y-$m-$d");
    return $date;
  }
  
  /**
   * @param string $request 
   */
  public function dispatch($request){
    //Split URL by / and remove empty matches
    $all_params = array_filter(explode('/', $request), 'strlen');
    $params = array();
    $n_params = sizeof($all_params);
    
    //Fold array
    foreach($all_params as $param){
      $params[] = $param;
    }
    unset($param);
    
    //Init template engine and template vars
    $tpl = new MyTPL();
    $title = 'Page';
    $template = 'invalid_page';
    $vars = array();
    $vars['baseurl'] = $this->baseurl;

    $today = new DateTime('today');
    $grades = Config::$grades;
    $redirect = false;
    
    $grade;
    $day;
    $month;
    $year;
    
    switch($n_params){
    	case 0:
    	  $title = 'Vertretungsplan &Uuml;bersicht';
    	  $template = 'vplan_overview';
    	  $vars['grades'] = $grades;
    	  break;
    	case 1:
    	  $grade = strtoupper($params[0]);
    	  if(in_array($grade, $grades)){
          	  $title = "$grade - Vertretungsplan";
          	  $template = 'vplan_grade';
    	  }else{
    	    $title = "Unbekannte Stufe - Vertretungsplan";
    	    $template = 'vplan_grade_notfound';
    	  }
          $vars['grade'] = $grade;
          $vars['dates'] = $this->getRelevantDates($grade);
    	  break;
    	case 2:
    	  $grade = strtoupper($params[0]);
      	  $vars['grade'] = $grade;
    	  if($params[1] == 'latest'){
            $template = 'vplan_single';
          	$title = "$grade - Vertretungsplan";

          	$vplan = $this->storage->getLatestPlan($grade);
          	
          	if(!$vplan || is_numeric($vplan)){
          	  $error_code = $vplan;
          	  $vplan = new VPlan($this->storage->getLatestPlan($grade, true), $grade);
          	  $vplan->setErrorCode($error_code);
          	}
          	
            $vplan->local_url = $this->makeLocalUrl($grade, $vplan->date);
        	$vars['vplan'] = $vplan;
  	        $date_text = $vplan->date_text;
      	    $title = "$grade - $date_text - Vertretungsplan";
        	
        	if(!$vplan->error_code){
      	      $vars['date_text'] = $date_text;
        	}else{
              $template = 'vplan_notfound';
        	}
    	    break;
    	  }elseif(is_numeric($params[1])){
    	    $redirect = true;
    	    $params[2] = $today->format('m');
    	    $n_params = 3;
    	  }
    	case 3:
          $vars['grade'] = $grade;
    	  $redirect = true;
    	  $params[3] = $today->format('Y');
    	  $n_params = 4;
    	case 4:
    	  $grade = strtoupper($params[0]);
          $template = 'vplan_single';
          $title = "$grade - Vertretungsplan";
    	  $date = $this->makeDate($params[1], $params[2], $params[3]);
    	  $vplan = $this->storage->getPlan($grade, $date);
    	  
    	  if(!$vplan || is_numeric($vplan)){
    	    $error_code = $vplan;
    	    $vplan = new VPlan($this->storage->getLatestPlan($grade, true), $grade);
    	    $vplan->setErrorCode($error_code);
    	  }
    	   
    	  $vplan->local_url = $this->makeLocalUrl($grade, $vplan->date);
    	  $vars['vplan'] = $vplan;
    	  $date_text = $vplan->date_text;
    	  $title = "$grade - $date_text - Vertretungsplan";
    	  if(!$vplan->error_code){
    	    $vars['grade'] = $grade;
    	    $vars['date_text'] = $date_text;
    	  }else{
    	    $template = 'vplan_notfound';
    	  }
    	  break;
    	default:
    	  break;
    }
    if($redirect){
      $this->redirect($this->makeLocalUrl(strtoupper($params[0]), $this->makeDate($params[1], $params[2], $params[3])));
    }
    
    
    //Draw page
    $tpl->assign('title', $title);
    $tpl->assign($vars);
    $tpl->draw($template);
  }
  
  public function getRelevantDates($grade){
    $format = Config::$page_date_format_full;
    $dates = array();
    $highlighted = false;
    
    $today = new DateTime('today');
    
    if($today->format('N')<6){
      $dates[] = array(
        'highlight' => true,
        'date' => $today,
        'text' => strftime($format, $today->getTimestamp()),
        'url' => $this->makeLocalUrl($grade, $today)
      );
      $highlighted = true;
    }

    $nextday = new DateTime('tomorrow');
    if($nextday->format('N')>5){
      $nextday = new DateTime('next monday');
    }
    $hl = (!$highlighted);
    $dates[] = array(
      'highlight' => $hl,
      'date' => $nextday,
      'text' => strftime($format, $nextday->getTimestamp()),
      'url' => $this->makeLocalUrl($grade, $nextday)
    );
    return($dates);
  }
}
