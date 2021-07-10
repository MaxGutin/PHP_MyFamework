<?php
error_reporting(-1);

use vendor\core\Router;
require "../vendor/libs/functions.php";

define('ROOT', dirname(__DIR__) );
$query = rtrim($_SERVER['QUERY_STRING'], '/');

function autoloader($class)
{
	$file = ROOT . "\\$class.php";
	if ( file_exists($file) ) require_once $file;
}
spl_autoload_register('autoloader');

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

//debug(Router::getRoutes());

Router::dispatch($query);