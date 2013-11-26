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
  
  public function makeLocalUrl($grade, $date){
    str_replace(
      array('{g}', '{d}', '{m}', '{y}'),
      array($grade, $date->format('d'), $date->format('m'), $date->format('Y')),
      '{g}/{d}/{m}/{y}'
    );
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
    
    $grade;
    $day;
    $month;
    $year;
    
    switch($n_params){
    	case 0:
    	  $title = 'Vertretungsplan &Uuml;bersicht';
    	  $template = 'vplan_overview';
    	  include('assets/grades.php');
    	  $vars['grades'] = $grades;
    	  break;
    	case 1:
    	  $grade = strtoupper($params[0]);
    	  $title = "Vertretungsplan $grade";
    	  $template = 'vplan_grade';
    	  $vars['grade'] = $grade;
    	  break;
    	case 2:
    	  $grade = $params[0];
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
      	      $vars['grade'] = $grade;
      	      $vars['date_text'] = $date_text;
        	}else{
              $template = 'vplan_notfound';
        	}
    	  }
    	  break;
    	default:
    	  break;
    }
    
    //Draw page
    $tpl->assign('title', $title);
    $tpl->assign($vars);
    $tpl->draw($template);
  }
  
}
