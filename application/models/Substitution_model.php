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
  
  public function delete_many_by_many($where){
    $where_str = '';
    foreach($where as $fieldname=>$condition){
      if(is_array($condition)){
        $value_str = '';
        foreach($condition as $value){
          $value_str .= "'$value', ";
        }
        $value_str = substr($value_str, 0, -2);
        $where_str .= "$fieldname in ($value_str) AND ";
      }else{
        $where_str .= "$fieldname = '$condition' AND ";
      }
    }
    $where_str = substr($where_str, 0, -4);
    
    $this->db->select('id')->from($this->table())->where($where_str);
    $query = $this->db->get();
    $ids = array();
    foreach($query->result() as $row){
      $ids[] = $row->id;
    }
    if(sizeof($ids) > 0) $this->delete_many($ids);
    return($ids);
  }
  
  public function deleteEmpty(){
    $this->delete_many_by_many(array('time' => '', 'teacher' => ''));
    print_r($this->db->last_query());
  }

}
