<?php

class Substitution_model extends MY_Model {
  
  public $before_create = array('created_at','updated_at');
  public $before_update = array('updated_at');
  
  public function get_uniques(){
    $grades = array();
    $table = $this->table();
    $query = $this->db->query("SELECT DISTINCT grade FROM $table ORDER BY grade ASC");
    foreach($query->result() as $row){
      $grades[] = $row->grade;
    }
    return($grades);
  }
  
  public function delete_empty(){
    $this->delete_many_by_many(array('time' => '', 'teacher' => ''));
  }
  
  public function get_all_ahead(){
    $today = new DateTime('today');
    $today = $today->format('Y-m-d');
    
    $data = $this->order_by('date asc, grade asc, time')->get_many_by("date >= '$today'");
    return($data);
  }

}
