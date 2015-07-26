<?php

class UsersController extends AppController {

	public $components = array('Cookie');

	public function isAuthorized($user) {
		if (in_array($this->action, array('changePassword', 'logout'))) {
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function login() {
		$signedUser = $this->Auth->user();
		if ($signedUser) {
			$address = $this->roleAddress($signedUser['role']);
			return $this->redirect($address);
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$role = $this->Auth->user('role');
				$address = $this->roleAddress($role);
				return $this->redirect($address);
			}
			else {
				$this->Session->setFlash(__('E-mail ou senha incorretos'), 'default', array('class' => 'post-error message'));
				unset($this->request->data['User']['password']);
			}
		}
	}

	public function index() {
		$users = $this->User->find('all', array(
			'order' => array('User.role', 'User.name')
		));
		$this->set('users', $users);
	}

	public function controlPanel() {
		
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('Usuário criado com sucesso: e-mail enviado para') . ' ' . $this->request->data['User']['email'], 'default', array('class' => 'post-success message'));
				return $this->redirect(array('action' => 'controlPanel'));
			}
			$this->Session->setFlash(__('Erro ao criar usuário'), 'default', array('class' => 'post-error message'));
		}
	}

	public function changePassword() {
		if ($this->request->is('post')) {
			$this->User->id = $this->Auth->user('id');
			if ($this->User->save(
				$this->request->data,
				array('fieldList' => array(
					'current_password',
					'password',
					'password_confirmation',
				))
			)) {
				$signedUser = $this->Auth->user();
				$address = $this->roleAddress($signedUser['role']);
				$this->Session->setFlash(__('Senha alterada com sucesso'), 'default', array('class' => 'post-success message'));
				return $this->redirect($address);
			}
			$this->Session->setFlash(__('Um erro impediu a alteração de senha'), 'default', array('class' => 'post-error message'));
			unset($this->request->data['User']);
		}
	}

    public function logout() {
    	return $this->redirect($this->Auth->logout());
    }

    private function roleAddress($role) {
    	switch($role) {
    		case 'Administrador':
    			return array('action' => 'controlPanel');
    		case 'Cliente':
    			return array('controller' => 'hotels', 'action' => 'totemHome');
    		default:
    			return array('action' => 'totemHome');
    	}
    }

}
