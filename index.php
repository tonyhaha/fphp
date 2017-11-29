<?php
ini_set('display_errors',1);
error_reporting(E_ERROR);
date_default_timezone_set('PRC');
// DIR
define('ROOT',__DIR__);
define('HOST','http://'.$_SERVER['HTTP_HOST']);
define('DIR_APP', ROOT.'/app/');
define('CONFIG', ROOT.'/config/');
define('DIR_CORE', ROOT.'/vendor/core/');
define('DIR_LIBRARY', ROOT.'/vendor/core/library/');
define('DIR_LOGS', ROOT.'/log/');
define("DEFAULT_ROUTE",'user/index');


require_once __DIR__.'/vendor/autoload.php';
$registry = new \Core\engine\Registry();
$loader = new \Core\engine\Loader($registry);
$config = $loader->config('config');
$registry->set('load', $loader);
$registry->set('config',$config);
$router = \Core\engine\Router::get();
$action = new \Core\engine\Action($router);
$action->execute($registry);

