<?php

class AttractionHotel extends AppModel {

	public $belongsTo = array('Attraction', 'Hotel');

	public function createFromHotel($hotel) {
		$attractions = $this->Attraction->find('all');
		foreach ($attractions as $attraction) {
			$this->saveWithDistance($hotel, $attraction);
		}
	}

	public function createFromAttraction($attraction) {
		$hotels = $this->Hotel->find('all');
		foreach ($hotels as $hotel) {
			$this->saveWithDistance($hotel, $attraction);
		}
	}

	private function saveWithDistance($hotel, $attraction) {
		$hotelId = $hotel['Hotel']['id'];
		$attractionId = $attraction['Attraction']['id'];

		$curl = curl_init();

		// Get distance between hotel and attraction
		$baseUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json?';
		$origin = 'origins=' . $hotel['Hotel']['latitude'] . ',' . $hotel['Hotel']['longitude'];
		$destination = 'destinations=' . $attraction['Attraction']['latitude'] . ',' . $attraction['Attraction']['longitude'];
		$url = $baseUrl . $origin . '&' . $destination;
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		));
		$response = json_decode(curl_exec($curl), true);
		$distance = $response['rows'][0]['elements'][0]['distance']['value'];

		$this->create();
		$this->save(array(
			'hotel_id' => $hotelId,
			'attraction_id' => $attractionId,
			'distance' => $distance,
			'visit_count' => 0,
		));
		
		curl_close($curl);

	}

	public function incrementVisitCount($hotelId, $attractionId) {
		$this->updateAll(
			array('AttractionHotel.visit_count' => 'AttractionHotel.visit_count+1'),
			array(
				'AttractionHotel.hotel_id' => $hotelId,
				'AttractionHotel.attraction_id' => $attractionId,
			)
		);
	}

}