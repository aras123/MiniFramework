<?php
namespace Framework;
use Framework\Cache;
class View {
	public $showLayout = true;
	public $pathLayout;
	public $content;
	public $vars = array();
	public $request;
	public $cache = false;
	public function __construct() {
		$this -> request = new Request();
	}

	/* Deklarowanie zmiennych */
	public function set($index, $value) {
		$this -> vars[$index] = $value;
	}

	/* Pobieranie zmiennych */
	public function get($index) {
		if (isset($this -> vars[$index]))
			return $this -> vars[$index];
		return false;
	}
	/* Funkcja wyświetla szablon dla controller i action */
	public function display($controller, $action) {
		
		$controller = strtolower($controller);
		$action = strtolower($action);
		if (!empty($this -> pathLayout))
			$file = 'Application/View/' . $this -> pathLayout;
		else
			$file = 'Application/View/' . $controller . '/' . $action . '.phtml';
		if (file_exists($file)) {
			if ($this -> showLayout == true) {
				$this -> content = $file;
				require_once ('Application/View/layout.phtml');
			} else {
				require ($file);
			}

		} else
			echo 'Brak pliku widoku';
	}

	/* Funkcja dzięki której możemy sami wybrać jaki szablon ma zostać wykorzystany podczaś wykonywania akcji */
	public function setLayout($file = null) {
		$this -> pathLayout = strtolower($file);
	}

	/* Funkcja która przyjmuje parametry TRUE i FALSE. Pokazać LAYOUT czy też nie */
	public function showLayout($showLayout = true) {
		$this -> showLayout = $showLayout;
	}

}
