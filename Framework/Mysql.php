<?php
namespace Framework;
use PDO;
class Mysql extends PDO {
	/* Jest to nic innego jak PDO tylko, że w dane do bazy pobierane są z konfiguracji (Config/mysql.php). Dodatkowo może swoje dodatki dopisać */
	public function __construct() {
		Config::load('mysql');
		$db = Config::get('mysql');
		parent::__construct('' . $db['driver'] . ':host=' . $db['host'] . ';dbname=' . $db['dbname'] . '', $db['login'], $db['password']);
		$this -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$this -> query('SET NAMES utf8');
		$this -> query('SET CHARACTER_SET utf8_unicode_ci');
	}

}
