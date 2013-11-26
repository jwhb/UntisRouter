<?php

namespace Rain;

class MyTPL extends Tpl{

  function draw($tpl_name, $return_string = false){
    try{
      if(!isset($this->var['title'])) $this->assign('title', 'Page');
      parent::draw('header', $return_string);
      parent::draw($tpl_name, $return_string);
      parent::draw('footer', $return_string);
    }catch(Exception $e){
      die('Could not render page. Error: ' . $e->getMessage());
    }
  }
  
}
