<?php
namespace Framework;
use Framework\View;
abstract class Controller {
	public $request;
	public $view;
	/* start controller */
	public function __construct() {
		$this -> request = new Request();
		$this -> view = new View();
	}

	/* wyświetlenie szablonu */
	public function __destruct() {
		$this -> view -> display($this -> request -> getController(), $this -> request -> getAction());
	}

}
