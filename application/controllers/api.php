<?php

class Api extends MY_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function index(){
    exit('Error: Invalid API call.');
  }
  
  public function get($grade = 'all', $date = 'ahead'){
    $chain = $this->substitutions->order_by('date asc, grade asc, time');
    $today = new DateTime('today');
    $grade = mysql_real_escape_string($grade);
    $grade_where = ($grade != 'all' && $grade != '')? "grade = '$grade' AND " : '';
    $substs = array();
    switch($date){
    	case 'today':
    	  $substs = $chain->get_many_by($grade_where . 'date = "' . $today->format('Y-m-d') . '"');
    	  break;
    	case 'ahead':
    	  $substs = $chain->get_many_by($grade_where . 'date >= "' . $today->format('Y-m-d') . '"');
    	  break;
    	case 'anytime':
    	  $substs = $chain->get_many_by($grade_where);
    	  break;
    }
    echo(json_encode($substs));
    exit();
  }
  
}
