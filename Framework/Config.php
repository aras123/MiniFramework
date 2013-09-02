<?php
namespace Framework;
class Config {
	public static $configs = array();
	/* Funkcja wczytuje cały plik do konfiguracji */
	public static function load($file) {
		if (!array_key_exists($file, self::$configs)) {
			if (file_exists('Config/' . $file . '.php')) {
				return self::$configs[$file] =
				include_once('Config/' . $file . '.php');
			} else
				throw new Exception("Nie ma takiego configu!", 1);
		}
	}

	/* Funkcja odpowiadająca za pobranie konfiguracji */
	public static function get($path) {
		$path = explode('.', $path);
		$array = self::$configs;
		do {
			$key = array_shift($path);
			if (isset($array[$key])) {
				if (!empty($path)) {
					if (is_array($array[$key])) {
						$array = $array[$key];
					} else {
						break;
					}
				} else {
					return $array[$key];
				}
			} else {
				break;
			}

		} while (!empty($path));
	}

}
