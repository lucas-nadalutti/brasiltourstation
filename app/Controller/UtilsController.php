<?php

class UtilsController extends AppController {
	
	public $components = array(
		'Session'
	);
	
	public $uses = array();
	
	public function beforeFilter() {
		$this->Auth->allow(array('changeLanguage'));
		parent::beforeFilter();
	}
	
	public function changeLanguage($language) {
		$this->Session->write('Config.language', $language);
		return $this->redirect($this->referer());
	}
	
}