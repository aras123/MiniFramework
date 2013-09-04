<?php
namespace Application\Controller;
use Framework\Controller;
use Framework\Filter;
use Application\Model\Album;

class IndexController extends Controller {
	public function _init() {
	}
	
	public function IndexAction() {
		$albums = new Album();
		$this -> view -> albums = $albums -> fetchAll();
	}

	public function AddAction() {
		$filtr = array(
			'artist'=>'string',
			'title' =>'string'
		);
			
		if (isset($_POST['artist']) AND isset($_POST['title'])) {
				$_POST = Filter::get($_POST,$filtr);
			if (!empty($_POST['artist']) AND !empty($_POST['title'])) {
				$artist = trim($_POST['artist']);
				$title = trim($_POST['title']);
				//check in base
				$albums = new Album();
				if ($albums -> Check($artist, $title)) {
					if ($albums -> Add($artist, $title)) {
						$this -> view -> set('message','Udało się dodać');
						$this -> view -> set('form',array('artist'=>'','title'=>''));
					} else {
						$this -> view -> set('message','Wystąpił nieznany błąd, spróbuj później');
						$this -> view -> set('form',array('artist' => $artist, 'title' => $title));
					}
				} else {
					$this -> view -> set('message','Taki wpis już istnieje');
					$this -> view -> set('form',array('artist' => $artist, 'title' => $title));
				}
			} else {
				$this -> view -> set('message','Proszę wypełnić wszystkie pola');
				$this -> view -> set('form',array('artist' => $_POST['artist'], 'title' => $_POST['title']));
			}
		}
	}
	public function DeleteAction() {
		
	}

}
