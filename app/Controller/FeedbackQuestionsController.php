<?php

class FeedbackQuestionsController extends AppController {

	public function isAuthorized($user) {
		if ($user['role'] === 'Cliente') {
			if (in_array($this->action, array('showQuestionnaire'))) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}

	public function index($id) {
		$this->loadModel('Hotel');
		$this->Hotel->Behaviors->load('Containable');
		$hotel = $this->Hotel->find('first', array(
			'conditions' => array('Hotel.id' => $id),
			'contain' => array(
				'User',
				'FeedbackQuestion' => array(
					'FeedbackQuestionOption'
				)
			),
		));
		$this->set('hotel', $hotel);
	}

	public function save($hotelId, $questionId = null) {
		if ($this->request->is('post')) {
			if ($this->FeedbackQuestion->saveAll($this->request->data)) {
				$this->Session->setFlash(
					__('Pergunta cadastrada com sucesso'),
					'default',
					array('class' => 'post-success message')
				);
				return $this->redirect(
					array('action' => 'index', $hotelId)
				);
			}
			$this->Session->setFlash(
				__('Erro ao cadastrar pergunta'),
				'default',
				array('class' => 'post-error message')
			);
		}
		$this->loadModel('Hotel');
		$this->Hotel->Behaviors->load('Containable');
		$hotel = $this->Hotel->find('first', array(
			'conditions' => array('Hotel.id' => $hotelId),
			'contain' => 'User',
		));
		$this->set('hotel', $hotel);
		if ($questionId) {
			$this->FeedbackQuestion->Behaviors->load('Containable');
			$question = $this->FeedbackQuestion->find('first', array(
				'conditions' => $questionId,
				'contain' => array('FeedbackQuestionOption'),
			));
			$this->request->data = $question;
			$this->set('question', $question);
		}
	}

	public function showQuestionnaire() {
		$userHotel = $this->Auth->user();
		$hotelId = $userHotel['Hotel']['id'];

		if ($this->request->is('post')) {
			$this->loadModel('FeedbackAnswerList');
			$this->FeedbackAnswerList->create();
			$this->request->data['FeedbackAnswerList']['hotel_id'] = $hotelId;
			if ($this->FeedbackAnswerList->saveAll($this->request->data)) {
				$this->Session->setFlash(
					__('Muito obrigado por responder ao nosso questionário!'),
					'default',
					array('class' => 'post-success message')
				);
				return $this->redirect(
					array('controller' => 'hotels', 'action' => 'totemHome')
				);
			}
			$this->Session->setFlash(
				__('Por favor, confira suas respostas'),
				'default',
				array('class' => 'post-error message')
			);
		}

		$this->loadModel('Hotel');
		$this->Hotel->Behaviors->load('Containable');
		$hotel = $this->Hotel->find('first', array(
			'conditions' => array('id' => $hotelId),
			'contain' => array(
				'FeedbackQuestion' => array(
					'FeedbackQuestionOption' => array(
						'fields' => array('id', 'question_option')
					),
				),
			),
		));
		$this->set('hotel', $hotel);
	}

}