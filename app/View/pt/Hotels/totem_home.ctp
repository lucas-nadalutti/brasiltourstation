<div class="col-md-9">
	<div id="totem-home-map-canvas-box" class="col-md-12">
		<div id="totem-home-loading-map">
			Carregando mapa...
		</div>
		<div id="totem-home-map-canvas" hidden></div>
	</div>
	<div id="real-time-info" class="col-md-12">

		<div id="quotes" class="col-md-5 home-info-box">
			<div class="col-md-4 real-time-image">
				<?php echo $this->Html->image('cotacoes.png'); ?>
			</div>
			<div class="col-md-8">
				<h4 class="home-info-box-title">Cotações atuais</h4>
				<?php
					echo '<p class="quote-info">';
					echo '<span class="quote-symbol"><i class="fa fa-usd"></i></span> ' . $quotes['dollar'];
					echo '</p>';
					echo '<p class="quote-info">';
					echo '<span class="quote-symbol"><i class="fa fa-eur"></i></span> ' . $quotes['euro'];
					echo '</p>';
					echo '<p class="quote-info">';
					echo '<span class="quote-symbol"><i class="fa fa-gbp"></i></span> ' . $quotes['pound'];
					echo '</p>';
				?>
			</div>
		</div>

		<div class="col-md-2"></div>

		<div id="forecast" class="col-md-5 home-info-box">
			<div class="col-md-4 real-time-image">
				<?php echo $this->Html->image('previsao-tempo.png'); ?>
			</div>
			<div class="col-md-8">
				<div id="forecast-title" class="col-md-12">
					<h4 class="home-info-box-title">Previsão do tempo</h4>
					<?php
						echo '<p class="forecast-subtitle">';
						echo '<span class="forecast-date">' . $forecastData['date'] . '</span> | ';
						echo '<span class="forecast-place">' . $forecastData['place'] . '</span>';
						echo '</p>';
					?>
				</div>
				<div id="forecast-container" class="col-md-12">
					<div class="col-md-6 forecast-icon">
						<?php echo $this->Html->image('previsao-exemplo.png'); ?>
					</div>
					<div class="col-md-6 temperature-info">
						<?php
							echo '<div class="temperature">';
							echo '<i class="fa fa-caret-square-o-up max-temperature"></i> ' . $forecastData['max'];
							echo '°</div>';
							echo '<div class="temperature">';
							echo '<i class="fa fa-caret-square-o-down min-temperature"></i> ' . $forecastData['min'];
							echo '°</div>';
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3">
	<div id="most-accessed-attractions" class="col-md-12 home-info-box">
		<h3 class="top-5-title">Top 5 Atrações</h3>
		<!--<p class="top-5-subtitle">Atrações</p>-->
		<?php
			foreach($top5Attractions as $attraction) {
				$id = $attraction['Attraction']['id'];
				$name = $attraction['Attraction']['name'];

				echo $this->Html->link(
					$name,
					array('controller' => 'attractions', 'action' => 'show', $id),
					array('class' => 'top-5-link attraction-link')
				);
			}
		?>
	</div>
	<div id="most-accessed-packages" class="col-md-12 home-info-box">
		<h3 class="top-5-title">Top 5 Pacotes</h3>
		<?php
		
			echo $this->Html->link(
				'Pacote 1',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 2',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 3',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 4',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 5',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);
		?>
	</div>
</div>

<?php
	echo $this->Form->hidden(
		'latitude',
		array(
			'id' => 'latitude',
			'value' => $latitude
		)
	);
	echo $this->Form->hidden(
		'longitude',
		array(
			'id' => 'longitude',
			'value' => $longitude
		)
	);
?>

<script>
	var HOTEL_ICON_URL = wr+'img/maps-icons/icone-hotel.png';
	var ATTRACTIONS_ICON_URL = wr+'img/maps-icons/icone-atracoes.png';
	var RESTAURANTS_ICON_URL = wr+'img/maps-icons/icone-onde-comer.png';
	var SHOPPINGS_ICON_URL = wr+'img/maps-icons/icone-onde-comprar.png';

	$(document).ready(function() {
		$.get(wr+'attractions/jsonList', function(data) {
			var attractions = $.parseJSON(data);
			$('#totem-home-loading-map').hide();
			$('#totem-home-map-canvas').show();
			renderMap(attractions);
		});
	});

	function renderMap(attractions) {

		var latitude = $('#latitude').val();
		var longitude = $('#longitude').val();
		var mapOptions = {
			center: new google.maps.LatLng(latitude, longitude),
			zoom: 14,
		};
		var map = new google.maps.Map($('#totem-home-map-canvas')[0], mapOptions);

		createMarker(map, latitude, longitude, 'Nosso hotel', HOTEL_ICON_URL);

		attractions.map(function(attraction) {
			createMarkerFromAttraction(map, attraction);
		});
	}

	function createMarkerFromAttraction(map, attraction) {
			var attractionIcons = {
				'Attraction': ATTRACTIONS_ICON_URL,
				'Restaurant': RESTAURANTS_ICON_URL,
				'Shopping': SHOPPINGS_ICON_URL,
			}

			latitude = attraction['Attraction']['latitude'];
			longitude = attraction['Attraction']['longitude'];
			name = attraction['Attraction']['name'];
			iconUrl = attractionIcons[attraction['Attraction']['category']];


			createMarker(map, latitude, longitude, name, iconUrl);
	}

	function createMarker(map, latitude, longitude, title, iconUrl) {
		var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(latitude, longitude),
		    map: map,
		    title: title,
		    icon: {
		    	url: iconUrl,
		    	scaledSize: new google.maps.Size(40, 40)
		    },
		    animation: google.maps.Animation.DROP
		});

		var infoWindow = new google.maps.InfoWindow({
			content: '<div>'+title+'</div>',
			disableAutoPan: true
		});
		infoWindow.open(map, marker);
	}

</script>