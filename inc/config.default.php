<?php

final class Config {
  public static $url = 'http://domain.tld/extdata/{y}{m}{d}/Ver_Kla_{grade}.htm';
  public static $switch_time = 15;
  public static $page_date_format = '%d.%m.%Y';
  public static $page_date_format_full = '%A, %d.%m.%Y';
  public static $locale = array('de_DE@euro', 'de_DE', 'de', 'ge');

  //TODO: Remove this
  public static $grades = array('5A', '5C', '5D', '7B', '7C', '7D', '8A', '8B', 'EF', 'Q1', 'Q2');
  
  public static $error_code = array(
  	-1 => 'Unbekannter Fehler',
  	404 => 'Nicht gefunden'
  );
  
  public static $config_version = 2;
}
