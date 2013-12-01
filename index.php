<?php

use Rain\Tpl;
(@include_once('vendor/autoload.php')) or die('Composer Autoloader not present.
    Please run <b>composer.phar install</b> in the application\'s directory');
(@include_once('inc/config.php')) or die('Config file not present. Please rename
    \'<b>config.default.php</b>\' to \'<b>config.php</b>\'.');
require_once('inc/vplan.php');
require_once('inc/mytpl.php');
require_once('inc/router.php');
require_once('inc/storage.php');
//TODO: check vendor
setlocale(LC_TIME, Config::$locale);
$cfg_tpl = array(
    'tpl_dir' => 'inc/tpl/',
    'cache_dir' => 'inc/cache/',
    'auto_escape' => false
);
Tpl::configure($cfg_tpl);

$rt = new Router($_SERVER['REQUEST_URI']);
