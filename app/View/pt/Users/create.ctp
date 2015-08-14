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

	echo $this->Form->create('User', array('id' => 'user-form', 'inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));
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

	echo '<div class="input checkbox">';
	echo '<label>';
	echo $this->Form->input('Hotel.has_no_video', array('id' => 'has-no-video', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo 'Este hotel não possui vídeo</label>';
	echo '</div>';

	echo '<div id="video-form-part">';
	
	echo $this->Form->input('Hotel.Video.name', array('label' => 'Título do Vídeo:'));

	echo '<div>';
	echo '<p id="video-file"></p>';
	echo $this->Html->link(
		'Escolher Vídeo',
		'javascript:void(0);',
		array('id' => 'browse')
	);
	echo '</div>';

	echo $this->Form->hidden('Hotel.Video.url', array('id' => 'target-url'));
	echo $this->Form->hidden('Hotel.Video.type', array('id' => 'file-type'));

	echo '<div>';
	echo $this->Html->link(
		'Cadastrar',
		'javascript:void(0);',
		array('id' => 'start-upload'));
	echo '</div>';

	echo '</div>';

	echo '</div>';

	echo $this->Form->submit('Cadastrar', array('id' => 'submit-without-video', 'hidden' => true));
	echo $this->Form->end();

?>

<script>
	$(document).ready(function() {
		$('#user-role').change(function() {
			var selectedOption = $(this).val();
			if (selectedOption !== 'Cliente') {
				$('#submit-without-video').show();
				$('#hotel-data').find('input, select').attr('disabled', 'disabled');
				$('#hotel-data').slideUp();
			}
			else {
				$('#has-no-video').prop('checked', false).change();
				$('#hotel-data').find('input, select').removeAttr('disabled');
				$('#hotel-data').slideDown();
			}
		});

		/* Toggle video form part */

		$('#has-no-video').change(function() {
			if ($(this).is(':checked')) {
				$('#submit-without-video').show();
				$('#video-form-part').find('input, select').attr('disabled', 'disabled');
				$('#video-form-part').slideUp();
			}
			else {
				$('#submit-without-video').hide();
				$('#video-form-part').find('input, select').removeAttr('disabled');
				$('#video-form-part').slideDown();
			}
		});

		/* Configure video upload */

		var uploader = new plupload.Uploader({
			browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
			url: wr+'videos/uploadVideoFile',
			chunk_size: '2mb',
    		max_retries: 3,
    		unique_names: true,
    		multi_selection: false,
    		filters: [
            	{
            		title: 'Vídeo',
            		extensions: 'mp4',
            	}
        	],
		});

		uploader.init();

		uploader.bind('FilesAdded', function(up, files) {
			// Only 1 file will be added, always
			var currentFile = files[0];
			// If other files were previously chosen, erase them from the queue
			$.each(uploader.files, function (i, file) {
			    if (file && file.id != currentFile.id) {
			        uploader.removeFile(file);
			    }
			});
			var $videoFile = $('#video-file');
			$videoFile.html(
				'<span id="' + currentFile.id + '">' + currentFile.name + ' (' + plupload.formatSize(currentFile.size) + ') <b></b></span>'
			);
		});

		uploader.bind('ChunkUploaded', function(up, file, info) {
			var response = $.parseJSON(info['response']);
			if (
				info['status'] != 200
				|| !('OK' in response)
				|| !response['OK']
			) {
				up.stop();
				$('#upload-errors').append(
					'<p>Erro no upload do vídeo.</p>'
				);
				up.removeFile(file);
			}
		});

		uploader.bind('UploadProgress', function(up, file) {
			$('#'+file.id).find('b').html('<span>'+file.percent+'%</span>');
		});

		uploader.bind('FileUploaded', function(up, file) {
			// Set in the appropriate form inputs the file's unique name with which
			// it was saved in the server and its type, and then submit the form
			var $targetUrlInput = $('#user-form').find('#target-url');
			var $fileTypeInput = $('#user-form').find('#file-type');
			$targetUrlInput.val(file.target_name);
			$fileTypeInput.val(file.type);
			$('#user-form').submit();
		});

		uploader.bind('Error', function(up, err) {
			$('#upload-errors').append('<p>Error #' + err.code + ': ' + err.message + '</p>');
		});

		$('#start-upload').click(function() {
			uploader.start();
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