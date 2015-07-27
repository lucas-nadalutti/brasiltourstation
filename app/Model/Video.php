<?php

class Video extends AppModel {

	public $hasOne = array('Attraction', 'Package');
	public $hasMany = 'HotelVideo';

	public $validate = array(
		'url' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'name' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'type' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
	);

	public function save($data = null, $validate = true, $fieldList = array()) {
		if (parent::save($data, $validate, $fieldList)) {
			if (isset($data['Hotel'])) {
				$hotels = $data['Hotel'];
				foreach ($hotels as $hotel) {
					$hotelVideo = array(
						'hotel_id' => $hotel['id'],
						'video_id' => $this->id
					);
					$this->HotelVideo->create();
					$this->HotelVideo->save($hotelVideo);
				}
			}
			return true;
		}
		return false;
	}

	public function getFilesPath($fileName) {
		return $this->getFilesFolder() . DS . $fileName;
	}

	public function getFilesFolder() {
		// If the browser user is Selenium, get videos from a different place
    	if (stristr(env('HTTP_USER_AGENT'), 'selenium')) {
    		return 'tour_videos_test';
    	}
    	return 'tour_videos';
	}

}