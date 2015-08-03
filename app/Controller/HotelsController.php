<?php

class HotelsController extends AppController {

	// This is a disgusting temporary solution to replace accented characters
	private $accented = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
	private $replacements = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
	
	private function replace_accented_chars($str) {
		return str_replace($this->accented, $this->replacements, $str);
	}

	public $components = array('Session', 'WebQuery');

	public function isAuthorized($user) {
		if ($user['role'] === 'Cliente') {
			return true;
		}
		return parent::isAuthorized($user);
	}

	public function totemHome() {
		$userId = $this->Auth->user('id');
		$userHotel = $this->Hotel->User->find('first', array(
			'conditions' => array('User.id' => $userId),
			'recursive' => 1,
		));
		$latitude = $userHotel['Hotel']['latitude'];
		$longitude = $userHotel['Hotel']['longitude'];
		$this->set('latitude', $latitude);
		$this->set('longitude', $longitude);

		$this->loadModel('Attraction');
		$this->Attraction->virtualFields['visit_count'] = '
			SELECT visit_count
			FROM attractions_hotels
			WHERE attraction_id = Attraction.id AND hotel_id = '.$userHotel['Hotel']['id'].'
		';
		$top5Attractions = $this->Attraction->find('all', array(
			'order' => 'visit_count DESC',
			'limit' => 5,
		));
		$this->set('top5Attractions', $top5Attractions);

		$curl = curl_init();

		// Get currency quotes
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => 'http://developers.agenciaideias.com.br/cotacoes/json',
		));
		$quotes = curl_exec($curl);

		// Get weather forecast information
		$city = str_replace(' ', '-', $userHotel['Hotel']['city']);
		$state = $userHotel['Hotel']['state'];
		$url = 'http://developers.agenciaideias.com.br/tempo/json/';
		$params = strtolower($city . '-' . $state);
		$fullUrl = $url . $this->replace_accented_chars($params);
		curl_setopt($curl, CURLOPT_URL, $fullUrl);

		$forecast = json_decode(curl_exec($curl), true);
		$forecastData = array();
		if (!$forecast || !array_key_exists('cidade', $forecast)) {
			// Request to agenciaideias did not receive a valid response, so try
			// another source
			$url = 'http://api.openweathermap.org/data/2.5/forecast/daily';
			$params = '?lat='.$latitude.'&lon='.$longitude.'&cnt=3&mode=json';
			$fullUrl = $url . $params;
			curl_setopt($curl, CURLOPT_URL, $fullUrl);

			$forecast = json_decode(curl_exec($curl), true);
			$forecastData['place'] = $forecast['city']['name'];
			$forecastData['condition'] = $forecast['list'][0]['weather'][0]['main'];
			// Degrees data given by openweathermap is in Kelvin units
			$forecastData['min'] = $forecast['list'][0]['temp']['min'] - 273.15;
			$forecastData['max'] = $forecast['list'][0]['temp']['max'] - 273.15;
		}
		else {
			// Request to agenciaideias was valid
			$forecastData['place'] = $forecast['cidade'];
			$forecastData['date'] = $forecast['previsoes'][0]['data'];
			$forecastData['condition'] = $forecast['previsoes'][0]['descricao'];
			$forecastData['min'] = $forecast['previsoes'][0]['temperatura_min'];
			$forecastData['max'] = $forecast['previsoes'][0]['temperatura_max'];
		}
		curl_close($curl);

		//$this->set('quotes', json_decode($quotes, true));
		$this->set('quotes', $this->WebQuery->getCurrencyQuotes());
		$this->set('forecastData', $forecastData);
	}

	public function hotelInfo() {
		// TODO: Remove finds in actions where the user's hotel info is needed -
		// it's already in Auth->user()
		$userHotel = $this->Auth->user();
		$this->set('userHotel', $userHotel);
		print_r($userHotel);
		die();
		$videoId = $userHotel['Hotel']['video_id'];
		if ($videoId) {
			$video = $this->Hotel->Video->findById($videoId);
			$this->set('video', $video);
		}
	}

	public function tours() {
		$this->loadModel('Video');
		$this->set(
			'videosPath',
			$this->webroot . $this->Video->getFilesFolder() . DS
		);
		$user = $this->Auth->user();
		$this->Hotel->id = $user['Hotel']['id'];
		$videos = $this->Hotel->getVideos();
		$this->set('videos', $videos);
	}

	public function food() {

	}

	public function commerce() {

	}

	public function cars() {

	}

	public function olympics() {

	}

	public function store() {

	}

	public function info() {

	}

}