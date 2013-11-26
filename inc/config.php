<?php

final class Config {
  public static $url = 'http://localhost/WSK_extdata/{y}{m}{d}/Ver_Kla_{grade}.htm';
  public static $switch_time = 15;
  public static $page_date_format = '%d.%m.%Y';
  public static $page_date_format_full = '%A, %d.%m.%Y';
  public static $locale = array('de_DE@euro', 'de_DE', 'de', 'ge');
  
  public static $error_code = array(
  	-1 => 'Unbekannter Fehler',
  	404 => 'Nicht gefunden'
  );
}
