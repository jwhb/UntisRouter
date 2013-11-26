<?php

$url = 'http://ohg-bensberg.info/WSK_extdata/{y}{m}{d}/Ver_Kla_{grade}.htm';
$message = array(
	'no_grade' => 'Es wurde keine Stufe ausgew&auml;hlt!',
);
$switch_time = 15;
$grades = array('5A', '5C', '5D', '7B', '7C', '7D', '8A', '8B', 'EF', 'Q1', 'Q2');
$tracking = '<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://stats.jwhy.de/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "1"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
';

function redirect($url, $header = true){
  if($header){
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $url);
  }else{
    ?><!DOCTYPE html>
<html>
<header>
  <meta http-equiv="refresh" content="0; url=<?php echo $url; ?>">
</header>    
</html>
    <?php
  }
  exit();
}

function makeURL($dir, $params, $domain = ''){
	$url = $domain . $dir;
	foreach($params as $p){
	  $url .= $p . '/';
	}
	return($url);
}

function show_plan($params, $url, $date, $tracking = ''){
  $url = str_replace(
	    array('{grade}', '{d}', '{m}', '{y}'),
	    array($params[0], $params[1], $params[2], substr($params[3], 2)),
	    $url
  );
  $contents = '';
  $status = true;
  set_error_handler(function($severity, $message, $file, $line) { throw new ErrorException($message, $severity, $severity, $file, $line); });
  try{
    $contents = @file_get_contents($url);
    $pos = strpos($contents, '</head>');
    $contents = substr_replace($contents, $tracking, $pos, 0);
    if(!$contents) throw new Exception('Kein Inhalt');
  }catch(Exception $e){
    $dateformat = $date->format('d.m.Y');
    die("<!DOCTYPE html>
<html>
    <head>
        $tracking
    </head>
    <body>
        <p>Der Vertretungsplan f&uuml;r das angefragte Datum konnte nicht geladen werden.</p>
    </body>
</html>");
  }
  echo(preg_replace("/<img[^>]+\>/i", '',$contents));
}

$dir = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
$domain = 'http://' . $_SERVER['HTTP_HOST'];
$request = $_SERVER['REQUEST_URI'];

$raw_params = array_filter(explode('/', $request), 'strlen');
$params = array();
foreach($raw_params as $param){
  $params[] = $param;
}
$n_params = sizeof($params);

$date = (date('G', time()) < $switch_time)? new DateTime('today') : new DateTime('tomorrow');
if($date->format('N')>5){
  $date = new DateTime('next monday');
}

switch($n_params){
	case 0:
	  echo('<p>' . $message['no_grade'] . "</p>\n<p>");
	  foreach($grades as $grade){
        echo("<a href=\"$domain$dir$grade\">$grade</a><br>");
      }
      echo('<br>');
      exit();
	  break;
	case 1:
	  $params[1] = $date->format('d');
	  $n_params = 2;
	case 2:
	  $params[2] = $date->format('m');
	  $n_params = 3;
	case 3:
	  $params[3] = $date->format('Y');
	  $n_params = 4;
	  
	  redirect(makeURL($dir, $params, 'http://' . $_SERVER['HTTP_HOST']), false);
	  break;
	case 4:
	  show_plan($params, $url, $date, $tracking);
	  break;
}
