<?php
namespace Framework;
class Request {

	//vars define
	private $_controller;
	private $_action;
	private $_args = array();
	private $route;

	public function __construct() {
		$request = strtolower($_SERVER['REQUEST_URI']);
		//config global
		$path_dir = $this -> getHome();
		if (!empty($path_dir))
			$request = str_replace($path_dir, '', $request);
		//route from config
		$this -> route = Config::get('router');
		foreach ($this->route as $r => $key) {
			$r = str_replace('/', '\\/', $r);
			if (preg_match('/^' . $r . '$/', $request)) {
				$request = preg_replace('/^' . $r . '$/i', $key, $request);
				break;
			}
		}
		//end config route
		$parts = explode('/', $request);
		$parts = array_filter($parts);
		$this -> _controller = ($c = array_shift($parts)) ? $c : 'index';
		$this -> _action = ($c = array_shift($parts)) ? $c : 'index';
		//param
		for ($i = 0; $i < count($parts); $i = $i + 2) {
			$this -> _args[$parts[$i]] = (isset($parts[$i + 1])) ? $parts[$i + 1] : '';
		}

		//args
	}

	/* Funkcja @getController() pobiera aktualny controller */
	public function getController() {
		return ucfirst($this -> _controller);
	}

	/* Funkcja @getAction() pobiera aktualną metodę */
	public function getAction() {
		return ucfirst($this -> _action);
	}

	/* Funkcja @getParam() pobiera parametry np. getParam('id') dla: /index/index/id/2 */
	public function getParam($name = null) {
		if (array_key_exists($name, $this -> _args)) {
			return $this -> _args[$name];
		}
	}

	/* Funkcja @getUrl() przekierowuje na podany adres argumencie np. goUrl('http://google.pl') */
	public function goUrl($url) {
		return header('location: ' . strtolower($url));
	}

	/* Funkcja @getHome() pobiera adres strony głównej - jeśli stronę posiadamy w jakimś folderze to pokaże właśnie ten folder: np. http://localhost/framework wynik: framework */
	public function getHome() {
		$domena = $_SERVER['SCRIPT_NAME'];
		$domena = preg_replace('/\/index.php/', '', $domena);
		return strtolower($domena);
	}

	/* Funkcja @getUrl() pobiera cały adres w aktualnie znajdujęcej się stronie */
	public function getUrl() {
		$actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return strtolower($actual_link);
	}

	/* Funkcja @Url(array $array) funkcja generująca link. Arguemntem musi być tablica w które definiujemy controller, action oraz inne paramentry
	 * np. echo $this->request->Url(array('controller'=>'index','action'=>'index','id'=>2));
	 * Jeśli w konfiguracji dla routera jest taka ścieżka zdeklarowana to zmieni link na ten podany w konfiguracji
	 *  */
	public function Url(array $array) {
		$url = '';
		foreach ($array as $key => $value) {
			if ($key == 'controller' OR $key == 'action')
				$url .= '/' . $value;
			else
				$url .= '/' . $key . '/' . $value;
		}
		foreach ($this->route as $route_key => $route_value) {
			if ($route_value == $url)
				return $this -> getHome() . $route_key;
			preg_match_all('/\((.*?)\)/', $route_key, $result);
			$result = $result[0];
			if (count($result) > 0) {
				for ($i = 1; $i <= count($result); $i++) {
					$na[] = '$' . $i;
				}
				$value = str_replace('/', '\\/', str_replace($na, $result, $route_value));
				if (preg_match('/^' . $value . '$/', $url)) {
					$key = str_replace($result, $na, $route_key);
					return $this -> getHome() . preg_replace('/' . $value . '/', $key, $url);
				} else
					continue;
			} else
				continue;
		}
		return $this -> getHome() . $url;
	}

}
