<?php

class PackagesController extends AppController {

	public function isAuthorized($user) {
		if ($user['role'] === 'Cliente') {
			$allowedActions = array('packagesList');
			if (in_array($this->action, $allowedActions)) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Package->create();
			$data = $this->request->data;
			if (isset($data['Attraction'])) {
				$checkedAttractions = $data['Attraction'];
				$attractionsPackages = array();
				foreach ($checkedAttractions as $attraction) {
					$attractionsPackages[] = array(
						'attraction_id' => $attraction['id']
					);
				}
				unset($data['Attraction']);
				$data['AttractionPackage'] = $attractionsPackages;
			}
			if ($this->Package->saveAll($data)) {
				$this->Session->setFlash(__('Pacote cadastrado com sucesso'), 'default', array('class' => 'post-success message'));
				return $this->redirect(array('controller' => 'users', 'action' => 'controlPanel'));
			}
			$this->Session->setFlash(__('Erro ao cadastrar pacote'), 'default', array('class' => 'post-error message'));
		}
		$this->loadModel('Attraction');
		$attractions = $this->Attraction->find('all', array(
			'order' => 'name',
		));
		$this->set('attractions', $attractions);
	}

	public function packagesList() {
		
	}

}
