<?php

class Attraction extends AppModel {

	public $belongsTo = 'Video';
	public $hasMany = array('AttractionHotel', 'AttractionTag', 'AttractionPackage');

	public function afterSave($created, $options = array()) {
		// Create AttractionHotel records relating the newly created attraction
		// with every existing hotel
		$this->AttractionHotel->createFromAttraction($this->data);
	}

}