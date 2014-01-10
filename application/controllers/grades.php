<?php

class Grades extends MY_Controller{
  
  public function __construct(){
    parent::__construct();
  }
  
  public function _remap($grade){
    if($grade == 'index'){
      $this->index();
    }elseif($grade == 'update' && $this->uri->total_segments() > 2){
      $token = $this->uri->segment(3);
      $this->update($token);
    }else{
      $d = '';
      $m = '';
      $y = '';
      if($this->uri->total_segments() > 2){
        $d = $this->uri->segment(3, '');
        $m = $this->uri->segment(4, '');
        $y = $this->uri->segment(5, '');
      }
      $this->view($grade, $d, $m, $y);
    }
  }
  
  public function index(){
      $this->set_title($this->config->item('app_name'));
      $data = array();
      
      $this->template->write_view('content', 'substitutions/grades_list', $data, true);
      $this->template->render();
  }
  
  public function update($token = ''){
    if($token == $this->config->item('update_token')){
      $this->load->library('Vplan', array('index' => $this->config->item('vplan_index'), 'single' => $this->config->item('vplan_single')));
      foreach($this->vplan->updateAll() as $date) print($date . ' ');
    }elseif(strlen($token) == 0){
      $this->output->set_status_header('401');
      exit('No token supplied');
    }else{
      $this->output->set_status_header('403');
      exit('Invalid token');
    }
  }
  
  public function view($grade, $d, $m, $y){
    $data['grade'] = $grade;
    $date = $this->get_date($d, $m, $y, true);
    
    if(!$date){
      $this->set_title('Ung&uuml;ltiges Datum');
      $this->template->write_view('content', 'substitutions/invalid_date', $data, true);
    }else{
      $data['dates'] = $this->get_date_neighbors($date);
      if($grade == 'all'){
        $this->set_title('Alle Stufen');
        $data['substitutions'] = $this->substitutions->order_by('time')->get_many_by(array('date' => $date->format('Y-m-d')));
        
        $this->template->write_view('content', 'substitutions/list', $data, true);
      }else{
        $substitutions = $this->substitutions->order_by('time')->get_many_by(array('grade' => $grade, 'date' => $date->format('Y-m-d')));
        if(sizeof($substitutions) > 0){
          //Entries found
          $this->set_title(strtoupper($grade));
  
          $data['substitutions'] = $substitutions;
        
          $this->template->write_view('content', 'substitutions/single', $data, true);
        }else{
          //No entries found
          $this->set_title('Keine Eintr&auml;ge');
  
          $data['grade'] = $grade;
          //$data['substitutions'] = $this->substitutions->order_by('time')->get_all();
          
          $this->template->write_view('content', 'substitutions/not_found', $data, true);
        }
      }
    }
    $this->template->render();
  }
  
  private function force_weekday($date, $reverse = false){
    if($date->format('N') > 5){
      $weekday = $date->getTimestamp() + (8 - $date->format('N')) * 86400;
      if($reverse) $weekday = $date->getTimestamp() - ($date->format('N') - 5) * 86400;
      $date->setTimestamp($weekday);
    }
    return($date);
  }
  
  private function get_date($d, $m, $y, $time_switch = false){
    try{
      $today = new DateTime('today');
      if($time_switch && (new DateTime())->format('G') > 14) $today = new DateTime('tomorrow');
      $date = null;
      if(strlen($d) != 0){
        if(strlen($m) == 0) $m = $today->format('m');
        if(strlen($y) == 0) $y = $today->format('Y');
        $date = new DateTime("$y-$m-$d");
      }else $date = $today;
      $date = $this->force_weekday($date);
      return($date);
    }catch(Exception $e){
      return false;
    }
  }
  
  private function get_date_neighbors($date){
    $before = new DateTime();
    $before->setTimestamp($date->getTimestamp() - 86400);
    $before = $this->force_weekday($before, true);

    $after = new DateTime();
    $after->setTimestamp($date->getTimestamp() + 86400);
    $after = $this->force_weekday($after);
    
    return(array('before' => $before, 'base' => $date, 'after' => $after));
  }

}
