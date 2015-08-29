<?php

class PackagesController extends AppController {

	public function isAuthorized($user) {
		if ($user['role'] === 'Cliente') {
			$allowedActions = array('getPackages', 'packagesList', 'show', 'createReservation');
			if (in_array($this->action, $allowedActions)) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function packagesList() {
		$this->loadModel('Tag');
		$tags = $this->Tag->find('all', array(
			// TODO: get session language and order by correct language name
			'order' => 'name_pt',
		));
		$this->set('tags', $tags);
	}

	public function show($id) {
		$this->loadModel('User');
		$userId = $this->Auth->user('id');
		$hotel = $this->User->find('first', array(
			'conditions' => array('User.id' => $userId),
			'recursive' => 1,
		));
		$this->set('hotel', $hotel);

		$this->Package->Behaviors->load('Containable');
		$this->loadModel('Attraction');
		// $this->Attraction->virtualFields['distance'] = '
		// 	SELECT distance
		// 	FROM attractions_hotels
		// 	WHERE attraction_id = Attraction.id AND hotel_id = '.$hotel['Hotel']['id'].'
		// ';
		$package = $this->Package->find('first', array(
			'conditions' => array('Package.id' => $id),
			'contain' => array(
				'Video',
				'AttractionPackage' => array(
					// TODO: Investigate if this ordering is failproof
				    'order' => '(
				    	SELECT distance
				    	FROM attractions AS a
				    	LEFT JOIN attractions_hotels AS ah ON (
				    		a.id = ah.attraction_id
				    		AND ah.hotel_id = '.$hotel['Hotel']['id'].'
				    	)
				    	WHERE AttractionPackage.attraction_id = a.id
				    	LIMIT 1
				    )',
					'Attraction' => array(
						// XXX: For some reason, the query above only works with the line below
						'order' => 'id'
					)
				)
			)
		));

		if ($package['Video']['id']) {
			$url = $package['Video']['url'];
			$package['Video']['file_path'] = $this->Package->Video->getFilesPath($url);
		}
		$this->set('package', $package);
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

	public function getPackages() {
		$this->autoRender = false;

		// TODO: Optimize all queries in this action

		$start = $this->request->query['start'];
		$limit = $this->request->query['limit'];
		$sortCriterium = $this->request->query['sortCriterium'];
		if (isset($this->request->query['tags'])) {
			$tags = $this->request->query['tags'];
		}

		$this->loadModel('User');
		$this->User->recursive = 1;
		$loggedUser = $this->User->findById($this->Auth->user('id'));
		$hotelId = $loggedUser['Hotel']['id'];

		$this->Package->virtualFields['reservations'] = '
			SELECT COUNT(*)
			FROM package_reservations
			WHERE package_id = Package.id
		';

		// Sort method
		if ($sortCriterium === 'popularity') {
			$order = 'reservations DESC';
		}
		else {
			$order = 'Package.name ASC';
		}

		// Filters
		$conditions = array();
		if (isset($tags)) {
			$sqlTags = '(' . implode(',', $tags) . ')';
			// TODO: Make query to get packages that have all tags within its attractions
			// $conditions[] = '';
		}

		$this->Package->Behaviors->load('Containable');
		$options = array(
			'offset' => $start,
			'limit' => $limit,
			'order' => $order,
			'conditions' => $conditions,
			'contain' => array(
				'AttractionPackage' => array(
					'Attraction' => array(
						'AttractionTag' => array(
							'Tag'
						)
					)
				)
			)
		);

		$packages = $this->Package->find('all', $options);
		$total = $this->Package->find('count', array(
			'conditions' => $conditions,
		));
		echo json_encode(array(
			'total' => $total,
			'packages' => $packages,
		));
	}

	public function createReservation() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			if ($this->Package->saveAssociated($this->request->data)) {
				echo 'Reserva cadastrada com sucesso! Em breve entraremos em contato';
			}
			else {
				echo 'Erro ao cadastrar sua reserva';
			}
		}
	}

}
