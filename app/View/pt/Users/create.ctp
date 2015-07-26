<h1>Cadastro de Usuário</h1>

<?php

	$roleOptions = array('Cliente' => 'Cliente', 'Administrador' => 'Administrador');
	$states = array(
		'' => '',
		'AC' => 'AC',
		'AL' => 'AL',
		'AM' => 'AM',
		'AP' => 'AP',
		'BA' => 'BA',
		'CE' => 'CE',
		'DF' => 'DF',
		'ES' => 'ES',
		'GO' => 'GO',
		'MA' => 'MA',
		'MG' => 'MG',
		'MS' => 'MS',
		'MT' => 'MT',
		'PA' => 'PA',
		'PB' => 'PB',
		'PE' => 'PE',
		'PI' => 'PI',
		'PR' => 'PR',
		'RJ' => 'RJ',
		'RN' => 'RN',
		'RO' => 'RO',
		'RR' => 'RR',
		'RS' => 'RS',
		'SC' => 'SC',
		'SE' => 'SE',
		'SP' => 'SP',
		'TO' => 'TO',
	);

	echo $this->Form->create('User', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));
	echo $this->Form->input('username', array('label' => 'Login:'));
	echo $this->Form->input('name', array('label' => 'Nome:'));
	echo $this->Form->input('email', array('label' => 'E-mail:'));
	echo $this->Form->input('role', array('id' => 'user-role', 'label' => 'Tipo:', 'options' => $roleOptions));

	echo '<div id="hotel-data">';
	echo $this->Form->input('Hotel.address', array('id' => 'hotel-address', 'label' => 'Endereço:', 'placeholder' => '', 'style' => 'width: 30em;'));
	echo $this->Form->input('Hotel.city', array('id' => 'hotel-city', 'label' => 'Cidade:'));
	echo $this->Form->input('Hotel.state', array('id' => 'hotel-state', 'label' => 'Estado:', 'options' => $states));
	echo $this->Form->input('Hotel.phone', array('id' => 'hotel-phone', 'label' => 'Telefone:'));
	echo $this->Form->input('Hotel.latitude', array('id' => 'hotel-latitude', 'type' => 'text', 'readonly' => true));
	echo $this->Form->input('Hotel.longitude', array('id' => 'hotel-longitude', 'type' => 'text', 'readonly' => true));
	echo '<div id="map-canvas" style="width: 800px; height: 500px;"></div>';
	echo '</div>';

	echo $this->Form->submit('Cadastrar', array('class' => 'green button'));
	echo $this->Form->end();

?>

<script>
	$(document).ready(function() {
		$('#user-role').change(function() {
			var selectedOption = $(this).val();
			if (selectedOption !== 'Cliente') {
				$('#hotel-data').find('input, select').attr('disabled', 'disabled');
				$('#hotel-data').slideUp();
			}
			else {
				$('#hotel-data').find('input, select').removeAttr('disabled');
				$('#hotel-data').slideDown();
			}
		});
	});

	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(-14.235004, -51.925280),
			zoom: 3,
		};
		var map = new google.maps.Map($('#map-canvas')[0], mapOptions);
		var input = $('#hotel-address')[0];

		var autocomplete = new google.maps.places.Autocomplete(input);

		var infowindow = new google.maps.InfoWindow();
		var marker = new google.maps.Marker({
			map: map,
			anchorPoint: new google.maps.Point(0, -29)
		});

		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			var components = place.address_components;
			var city = '';
			var state = '';
			var types;
			// Find city and state
			for (var i = 0; i < components.length; i++) {
				types = components[i].types;
				if (types.indexOf('locality') > -1) {
					// This component is the city
					city = components[i].long_name;
				}
				if (types.indexOf('administrative_area_level_1') > -1) {
					// This component is the state
					state = components[i].short_name;
				}
			}
			$('#hotel-address').val(place.formatted_address);
			$('#hotel-city').val(city);
			$('#hotel-state').val(state.toUpperCase());
			$('#hotel-phone').val(place.formatted_phone_number);
			$('#hotel-latitude').val(place.geometry.location.lat().toFixed(6));
			$('#hotel-longitude').val(place.geometry.location.lng().toFixed(6));
			infowindow.close();
			marker.setVisible(false);
			if (!place.geometry) {
				return;
			}

			// If the place has a geometry, then present it on a map.
			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			}
			else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}
			marker.setIcon(({
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(35, 35)
			}));
			marker.setPosition(place.geometry.location);
			marker.setVisible(true);

			var address = '';
			if (place.address_components) {
				address = [
					(place.address_components[0] && place.address_components[0].short_name || ''),
					(place.address_components[1] && place.address_components[1].short_name || ''),
					(place.address_components[2] && place.address_components[2].short_name || '')
				].join(' ');
			}

			infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address + '</div>');
			infowindow.open(map, marker);
		});
	}

	google.maps.event.addDomListener(window, 'load', initialize);

</script>