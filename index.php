<?php
session_start();
//automatyczne pobieranie klas
function __autoload($class)
{
    if(file_exists($file)) {
    	return require_once $file;
    }
}
use Framework\Request;
use Framework\Router;

//odpalamy aplikację
$application = new Router(new Request());