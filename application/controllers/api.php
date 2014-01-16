<?php

class Api extends MY_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    exit('Error: Invalid API call.');
  }
  
  public function get($grade = 'all', $date = 'ahead'){
    $chain = $substitutions = $this->substitutions->order_by('time');
    $today = new DateTime('today');
    $substs = array();
    switch($date){
    	case 'ahead':
    	  $substs = $chain->get_many_by('date >= "' . $today->format('Y-m-d') . '"');
    	  break;
    	case 'anytime':
    	  $substs = $chain->get_all();
    	  break;
    }
    echo(json_encode($substs));
    exit();
  }
  
}
