<?php

class AttractionsController extends AppController {

	public function isAuthorized($user) {
		if ($user['role'] === 'Cliente') {
			if (in_array($this->action, array('attractionsList', 'show', 'getTotal', 'getAttractions'))) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function index() {
		$attractions = $this->Attraction->find('all', array(
			'order' => 'name'
		));
		$this->set('attractions', $attractions);
	}

	public function attractionsList($tag = null) {
		$this->loadModel('Tag');
		$tags = $this->Tag->find('all', array(
			// TODO: get session language and order by correct language name
			'order' => 'name_pt'
		));
		$this->set('tags', $tags);
	}

	public function show($id = null) {
		$this->loadModel('User');
		$userId = $this->Auth->user('id');
		$hotel = $this->User->find('first', array(
			'conditions' => array('User.id' => $userId),
			'recursive' => 1,
		));
		$attraction = $this->Attraction->find('first', array(
			'conditions' => array('Attraction.id' => $id),
			'recursive' => 1,
		));

		$this->set('hotel', $hotel);
		if ($attraction['Video']['id']) {
			$url = $attraction['Video']['url'];
			$attraction['Video']['file_path'] = $this->Attraction->Video->getFilesPath($url);
		}
		$this->Attraction->AttractionHotel->incrementVisitCount(
			$hotel['Hotel']['id'],
			$attraction['Attraction']['id']
		);
		$this->set('attraction', $attraction);
	}

	public function create() {
		if ($this->request->is('post')) {
			$this->Attraction->create();
			// List of tag IDs is passed in a string. Parse it and create AttractionTag
			// arrays that attend Cake's convention
			$tagIds = explode(',', $this->request->data['AttractionTag']['tags']);
			$attractionTags = array();
			foreach ($tagIds as $tagId) {
				$attractionTags[] = array(
					'tag_id' => $tagId,
				);
			}
			$this->request->data['AttractionTag'] = $attractionTags;
			// Remove Video part of data if "attraction has no video" box was checked
			if ($this->request->data['Attraction']['has_no_video']) {
				unset($this->request->data['Video']);
			}
			if ($this->Attraction->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Atração cadastrada com sucesso'), 'default', array('class' => 'post-success message'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Erro ao cadastrar atração'), 'default', array('class' => 'post-error message'));
		}
	}

	public function getAttractions() {
		$this->autoRender = false;

		// TODO: Optimize all queries in this action

		$start = $this->request->query['start'];
		$limit = $this->request->query['limit'];
		$sortCriterium = $this->request->query['sortCriterium'];
		$distance = $this->request->query['distance'];
		if (isset($this->request->query['tags'])) {
			$tags = $this->request->query['tags'];
		}

		$this->loadModel('User');
		$this->User->recursive = 1;
		$loggedUser = $this->User->findById($this->Auth->user('id'));
		$hotelId = $loggedUser['Hotel']['id'];
		$this->Attraction->virtualFields['distance'] = '
			SELECT distance
			FROM attractions_hotels
			WHERE attraction_id = Attraction.id AND hotel_id = '.$hotelId.'
		';
		$this->Attraction->virtualFields['visit_count'] = '
			SELECT visit_count
			FROM attractions_hotels
			WHERE attraction_id = Attraction.id AND hotel_id = '.$hotelId.'
		';

		// Sort method
		if ($sortCriterium === 'distance') {
			$order = 'distance ASC';
		}
		else if ($sortCriterium === 'popularity') {
			$order = 'visit_count DESC';
		}
		else {
			$order = 'name ASC';
		}

		// Filters
		$conditions = array();

		if (isset($tags)) {
			$sqlTags = '(' . implode(',', $tags) . ')';
			// Query to get only attractions that have ALL the given tags
			$conditions[] = '
				EXISTS (
					SELECT *
					FROM attractions_tags
					WHERE attraction_id = Attraction.id AND tag_id IN '.$sqlTags.'
					GROUP BY attraction_id
					HAVING COUNT(tag_id) = '.count($tags).'
				)
			';
		}
		if ($distance > 0) {
			$conditions[] = array('distance <' => $distance);
		}

		$this->Attraction->Behaviors->load('Containable');
		$options = array(
			'offset' => $start,
			'limit' => $limit,
			'order' => $order,
			'conditions' => $conditions,
			'contain' => array(
				'AttractionTag' => array(
					'Tag'
				)
			)
		);

		$attractions = $this->Attraction->find('all', $options);
		$total = $this->Attraction->find('count', array(
			'conditions' => $conditions,
		));
		echo json_encode(array(
			'total' => $total,
			'attractions' => $attractions,
		));
	}

}