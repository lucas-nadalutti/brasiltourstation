<?php

class TagsController extends AppController {

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public function index() {
		$tags = $this->Tag->find('all', array(
			'order' => 'name_pt'
		));
		$this->set('tags', $tags);
	}

	public function fetchAll() {
		$this->autoRender = false;
		// Remove 'Tag' key from returned records
		$tags = Set::extract('/Tag/.', $this->Tag->find('all'));
		echo json_encode($tags);
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Tag->create();
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('Tag cadastrada com sucesso'), 'default', array('class' => 'post-success message'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Erro ao cadastrar tag'), 'default', array('class' => 'post-error message'));
		}
	}

}