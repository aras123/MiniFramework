<?php
session_start();
//automatyczne pobieranie klas
function baseAutoload($class) {
	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if(file_exists($file)) {
    	return require_once $file;
    }
}
function frameworkAutoload($class) {
	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if(file_exists('../'.$file)) {
    	return require_once '../'.$file;
    }
}
spl_autoload_register('frameworkAutoload');
spl_autoload_register('baseAutoload');

use Framework\Config;
use Framework\Request;
use Framework\Router;

//wczytuje pliku konfiguracji
Config::load('router');
Config::load('global');

//odpalamy aplikację
$application = new Router(new Request());