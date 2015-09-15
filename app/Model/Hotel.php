<?php

class Hotel extends AppModel {

	public $belongsTo = array('User', 'Video');
	public $hasMany = array(
		'AttractionHotel',
		'FeedbackAnswerList',
		'FeedbackQuestion' => array(
			'order' => 'FeedbackQuestion.order_index',
		),
	);

	public $validate = array(
		'address' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'city' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'state' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'latitude' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'longitude' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
	);

	public function afterSave($created, $options = array()) {
		// Create AttractionHotel records relating the newly created hotel
		// with every existing attraction
		if ($created) {
			$this->AttractionHotel->createFromHotel($this->data);
		}
	}

}