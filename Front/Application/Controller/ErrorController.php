<?php
namespace Application\Controller;
use Framework\Controller;

class ErrorController extends Controller{
	public function _init() {
	}
	public function IndexAction() {
	    $this->view->setLayout('error.phtml');
        $this->view->message = 'Ups... Nieprawidłowy adres strony :(';
            
	}
}