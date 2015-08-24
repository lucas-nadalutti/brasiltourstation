<?php

class Package extends AppModel {

	public $belongsTo = 'Video';
	public $hasMany = array('AttractionPackage', 'PackageReservation');

}