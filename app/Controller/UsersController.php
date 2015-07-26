<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function index() {
		$user = array('User' => array('name' => 'bla'));
		$this->User->save($user);
	}

}