<?php

class Api extends MY_Controller{
  
  public function __construct(){
    parent::__construct();
    $this->load->model('substtext_model', 'substtext');
  }
  
  public function index(){
    die('Error: Invalid API call.');
  }
  
  public function get($grade = 'all', $date = 'ahead'){
    $grade = mysql_real_escape_string($grade);
    $date = mysql_real_escape_string($date);
    
    $today = new DateTime('today');
    $json = '';
    $error = '';
    
    if($grade == 'all' && $date == 'ahead'){
      $this->load->helper('file');
      $json = read_file('assets/export/vp_all_ahead.json');
      if(!$json) $json = json_encode(array('error' => 'Could not access cached export file.', 'errno' => '501'));
    }else{
      $grade_where = ($grade != 'all' && $grade != '') ? "grade = '$grade'" : '1';
      
      $date_where = '';
      switch($date){
        case 'today':
          $date_where = 'date = "' . $today->format('Y-m-d') . '"';
          break;
        case 'ahead':
          $date_where = 'date >= "' . $today->format('Y-m-d') . '"';
          break;
        case 'anytime':
          die('Permissions denied. Use \'ahead\' as date value instead!');
          $date_where = '1';
          break;
        default:
          $date_where = 'date = "' . $date . '"';
          break;
      }
      
      $substs = $this->substitutions->order_by('date asc, grade asc, time')->get_many_by("$date_where AND $grade_where");
      $notes = $this->substtext->order_by('date')->get_many_by($date_where);
      $json = json_encode(array('substitutions' => $substs, 'notes' => $notes));
    }
  
    echo($json);
    exit();
  }
  
}
