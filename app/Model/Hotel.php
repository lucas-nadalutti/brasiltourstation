<?php

class Hotel extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = 'AttractionHotel';

	public $validate = array(
		'address' => array(
			'rule' => 'notEmpty',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'city' => array(
			'rule' => 'notEmpty',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'state' => array(
			'rule' => 'notEmpty',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'latitude' => array(
			'rule' => 'notEmpty',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'longitude' => array(
			'rule' => 'notEmpty',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
	);

	public function afterSave($created, $options = array()) {
		// Create AttractionHotel records relating the newly created hotel
		// with every existing attraction
		$this->AttractionHotel->createFromHotel($this->id);
	}

}