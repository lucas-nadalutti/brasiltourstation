<h1>Informações sobre o Hotel</h1>

<?php
	echo $this->Form->hidden(
		'latitude',
		array(
			'id' => 'latitude',
			'value' => $loggedUser['Hotel']['latitude']
		)
	);
	echo $this->Form->hidden(
		'longitude',
		array(
			'id' => 'longitude',
			'value' => $loggedUser['Hotel']['longitude']
		)
	);
?>

<div id="map-canvas" style="width: 800px;height: 500px"></div>

<script>
	var map;
	function initialize() {
		var latitude = $('#latitude').val();
		var longitude = $('#longitude').val();
		var mapOptions = {
			center: new google.maps.LatLng(latitude, longitude),
			zoom: 18,
		};
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(latitude, longitude),
		    map: map,
		    title: 'Você está aqui'
		});

		var infowindow = new google.maps.InfoWindow();
		infowindow.setContent('<div>Você está aqui</div>');
		infowindow.open(map, marker);
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
