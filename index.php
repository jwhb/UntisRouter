<?php

use Rain\Tpl;
require('vendor/autoload.php');
require_once('inc/config.php');
require_once('inc/vplan.php');
require_once('inc/mytpl.php');
require_once('inc/router.php');
require_once('inc/storage.php');

setlocale(LC_TIME, Config::$locale);
$cfg_tpl = array(
    'tpl_dir' => 'inc/tpl/',
    'cache_dir' => 'inc/cache/',
    'auto_escape' => false
);
Tpl::configure($cfg_tpl);

$rt = new Router($_SERVER['REQUEST_URI']);
