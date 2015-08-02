<?php

class Package extends AppModel {

	public $belongsTo = 'Video';
	public $hasMany = 'AttractionPackage';

}