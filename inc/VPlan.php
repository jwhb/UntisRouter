<?php

class VPlan {
  
  public $date;
  public $date_text;
  public $date_text_full;
  public $grade;
  public $error = 'OK';
  public $error_code = 0;
  
  public function __construct($date, $grade = ''){
    $this->setDate($date);
    $this->grade = $grade;
  }
  
  public function setDate($date){
    $this->date = $date;
    $this->date_text = strftime(Config::$page_date_format, $date->getTimestamp());
    $this->date_text_full = strftime(Config::$page_date_format_full, $date->getTimestamp());
  }
  
  public function setErrorCode($code){
    $this->error_code = $code;
    $this->error = (isset(Config::$error_code[$code]))? Config::$error_code[$code] : Config::$error_code['-1'];
  }
  
}
