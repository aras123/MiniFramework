<?php
namespace Framework;
use Framework\View;
use Framework\Cache;
abstract class Controller {
	public $request;
	public $view;
	/* start controller */
	public function __construct() {
		$this -> request = new Request();
		$this -> view = new View();
		
	}
	public function cache($off=false) {
		if($off==true) return $this->cache = true;
		return $this->cache = false;
	}
	

	/* wyświetlenie szablonu */
	public function __destruct() {
		$this -> view -> display($this -> request -> getController(), $this -> request -> getAction());
	}

}
