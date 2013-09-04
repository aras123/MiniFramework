<?php
namespace Framework;
class Router {
	private $controller;
	private $action;
	/* konstruktor przyjmuje klasę Request w które znajdują się nazwy kontrollerów oraz metod */
	public function __construct(Request $request) {
		$this -> controller = $request -> getController();
		$this -> action = $request -> getAction();
		$class_name = $this -> controller . 'Controller';
		if (class_exists($class_name = 'Application\Controller\\' . $this -> controller . 'Controller')) {
			if (method_exists($class = new $class_name, $method = $this -> action . 'Action')) {
				if (method_exists($class, '_init'))
				$class -> _init();
				return $class -> {$method}();
				
			} else
				$request -> goUrl($request -> url(array('controller' => 'error', 'action' => 'index')));
		} else
			$request -> goUrl($request -> url(array('controller' => 'error', 'action' => 'index')));
	}

}
