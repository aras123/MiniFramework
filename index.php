<?php
session_start();
//automatyczne pobieranie klas
function __autoload($class)
{
	$file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if(file_exists($file)) {
    	return require_once $file;
    }
}
use Framework\Config;
use Framework\Request;
use Framework\Router;

//wczytuje pliku konfiguracji
Config::load('router');
Config::load('global');

//odpalamy aplikację
$application = new Router(new Request());