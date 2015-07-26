<div class="col-md-12 grid-wrapper">
	<div id="attraction-video-box" class="col-md-5">
		<div id="attraction-video-wrapper">
			<?php
				if ($attraction['Video']['id']) {
					echo '<video class="video-js vjs-default-skin" controls preload="auto">';
					echo '<source src="';
					echo $this->webroot . $attraction['Video']['file_path'];
					echo '" type="';
					echo $attraction['Video']['type'];
					echo '"/>';
					echo '</video>';
				}
				else {
					echo '<p>Esta atração ainda não possui um vídeo</p>';
				}
			?>
		</div>
	</div>

	<div id="attraction-description-box" class="col-md-7">
		<h3><?php echo $attraction['Attraction']['name']; ?></h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
</div>
<div class="col-md-12 grid-wrapper">
	<div id="route-map-box" class="col-md-8">
		<?php
			echo $this->Form->hidden(
				'hotel-latitude',
				array('id' => 'hotel-latitude', 'value' => $hotel['Hotel']['latitude'])
			);
			echo $this->Form->hidden(
				'hotel-longitude',
				array('id' => 'hotel-longitude', 'value' => $hotel['Hotel']['longitude'])
			);
			echo $this->Form->hidden(
				'attraction-latitude',
				array('id' => 'attraction-latitude', 'value' => $attraction['Attraction']['latitude'])
			);
			echo $this->Form->hidden(
				'attraction-longitude',
				array('id' => 'attraction-longitude', 'value' => $attraction['Attraction']['longitude'])
			);
		?>
		<div id="route-map-wrapper"></div>
	</div>
	<div id="travel-mode-selection-box" class="col-md-4">
		<h3>Tipo de Deslocamento</h3>
		<p>
			<input id="walking" type="radio" name="travel-mode" class="travel-mode-option" value="WALKING" />
			<label for="walking" class="travel-mode-label">
				<span class="travel-mode-icon"><i class="fa fa-male"></i></span>
				<span class="travel-mode-text">A pé</span>
			</label>
		</p>
		<p>
			<input id="bicycling" type="radio" name="travel-mode" class="travel-mode-option" value="BICYCLING" />
			<label for="bicycling" class="travel-mode-label">
				<span class="travel-mode-icon"><i class="fa fa-bicycle"></i></span>
				<span class="travel-mode-text">Bicicleta</span>
			</label>
		</p>
		<p>
			<input id="driving" type="radio" name="travel-mode" class="travel-mode-option" value="DRIVING" />
			<label for="driving" class="travel-mode-label">
				<span class="travel-mode-icon"><i class="fa fa-car"></i></span>
				<span class="travel-mode-text">Carro</span>
			</label>
		</p>
		<p>
			<input id="transit" type="radio" name="travel-mode" class="travel-mode-option" value="TRANSIT" />
			<label for="transit" class="travel-mode-label">
				<span class="travel-mode-icon"><i class="fa fa-bus"></i></span>
				<span class="travel-mode-text">Transporte Público</span>
			</label>
		</p>
	</div>
</div>

<?php
	echo $this->Html->script('videos-setup');
?>

<script>
	/*** Manipulation of travel mode options behaviour ***/

	$('.travel-mode-option').change(function() {
		var $checked = $('input[name=travel-mode]:checked');

		// Reset all labels' colors
		$('.travel-mode-label').each(function() {
			$(this).removeClass('travel-mode-selected');
		});

		var travelMode = $checked.val();
		calculateRoute(travelMode);
	});

	/*** End of travel mode options behaviour manipulation ***/

	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;

	function initialize() {
		directionsDisplay = new google.maps.DirectionsRenderer();
		map = new google.maps.Map($('#route-map-wrapper')[0]);
		directionsDisplay.setMap(map);
		// Check 'walking' option by default
		$('#walking').prop('checked', true).change();
	}

	function calculateRoute(travelMode) {
		var hotelLatitude = $('#hotel-latitude').val();
		var hotelLongitude = $('#hotel-longitude').val();
		var attractionLatitude = $('#attraction-latitude').val();
		var attractionLongitude = $('#attraction-longitude').val();
		var request = {
			origin: new google.maps.LatLng(hotelLatitude, hotelLongitude),
			destination: new google.maps.LatLng(attractionLatitude, attractionLongitude),
			travelMode: google.maps.TravelMode[travelMode]
		};
		directionsService.route(request, function(result, status) {
			var $checked = $('input[name=travel-mode]:checked');
			var $label = $checked.next('.travel-mode-label');
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
				$label.addClass('travel-mode-selected');
			}
			else {
				$label.addClass('travel-mode-disabled');
				var text = $label.find('.travel-mode-text').text();
				$label.find('.travel-mode-text').text(text+' (Impossível)');
				$checked.prop('disabled', true);
				checkNextRadioButton($checked);
			}
		});
	}

	function checkNextRadioButton($button) {
		var nextPtag;
		while ($('.travel-mode-option:enabled').length > 0) {
			$nextPtag = $button.parent().next('p');
			if ($nextPtag.length == 0) {
				$nextPtag = $('#travel-mode-selection-box p').first();
			}
			$button = $nextPtag.find('.travel-mode-option').first();
			if ($button.is(':enabled')) {
				$button.prop('checked', true).change();
				break;
			}
		}
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>