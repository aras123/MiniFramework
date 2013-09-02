<?php
namespace Application\Model;
class Album extends \Framework\Mysql {
	public function fetchAll() {
		$db = $this -> prepare('SELECT * FROM album');
		$db -> execute();
		return $db -> fetchAll();
	}

	public function Check($artist, $title) {
		$db = $this -> prepare('SELECT id FROM album WHERE artist=:artist OR title=:title LIMIT 1--');
		if ($db -> execute(array(':artist' => $artist, ':title' => $title))) {
			if ($db -> rowCount() == 0) {
				return true;
			} else
				return false;
		} else
			return false;
	}

	public function Add($artist, $title) {
		$db = $this -> prepare('INSERT INTO `album` (`id`,`artist`,`title`)VALUES(:id,:artist,:title)');
		if ($db -> execute(array(':id' => '', ':artist' => $artist, ':title' => $title)))
			return true;
		else
			return false;
	}

}
