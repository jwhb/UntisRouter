<?php

class SubstText_model extends MY_Model {

  public $_table = 'subst_texts';

  public $before_create = array('created_at','updated_at');
  public $before_update = array('updated_at');

  public function get_all_ahead(){
    $today = new DateTime('today');
    $today = $today->format('Y-m-d');

    $data = $this->order_by('date')->get_many_by("date >= '$today'");
    return($data);
  }

}
