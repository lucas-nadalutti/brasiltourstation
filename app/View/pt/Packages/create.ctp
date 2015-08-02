<h1>Cadastro de Pacote</h1>

<?php

	echo $this->Form->create('Package', array('id' => 'attraction-form', 'inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));

	echo $this->Form->input('name', array('label' => 'Nome:'));

	echo '<h2>Atrações do pacote</h2>';

	foreach($attractions as $i => $attraction) {
		echo '<div class="input checkbox">';
		echo '<label>';
		echo $this->Form->input('Attraction.'.$i.'.id', array('type' => 'checkbox', 'label' => false, 'div' => false, 'hiddenField' => false, 'value' => $attraction['Attraction']['id']));
		echo $attraction['Attraction']['name'] . '</label>';
		echo '</div>';
	}

	echo '<h2>Vídeo</h2>';

	echo '<div class="input checkbox">';
	echo '<label>';
	echo $this->Form->input('Package.has_no_video', array('id' => 'has-no-video', 'type' => 'checkbox', 'label' => false, 'div' => false));
	echo 'Este pacote não possui vídeo</label>';
	echo '</div>';

	echo '<div id="video-form-part">';
	
	echo $this->Form->input('Video.name', array('label' => 'Título do Vídeo:'));

	echo '<div>';
	echo '<p id="video-file"></p>';
	echo $this->Html->link(
		'Escolher Vídeo',
		'javascript:void(0);',
		array('id' => 'browse')
	);
	echo '</div>';

	echo $this->Form->hidden('Video.url', array('id' => 'target-url'));
	echo $this->Form->hidden('Video.type', array('id' => 'file-type'));

	echo '<div>';
	echo $this->Html->link(
		'Cadastrar',
		'javascript:void(0);',
		array('id' => 'start-upload'));
	echo '</div>';

	echo '</div>';

	echo $this->Form->submit('Cadastrar', array('id' => 'submit-without-video', 'hidden' => true));

	echo $this->Form->end();

?>

<script>
	$(document).ready(function() {

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
			browse_button: 'browse',
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
			var $targetUrlInput = $('#attraction-form').find('#target-url');
			var $fileTypeInput = $('#attraction-form').find('#file-type');
			$targetUrlInput.val(file.target_name);
			$fileTypeInput.val(file.type);
			$('#attraction-form').submit();
		});

		uploader.bind('Error', function(up, err) {
			$('#upload-errors').append('<p>Error #' + err.code + ': ' + err.message + '</p>');
		});

		$('#start-upload').click(function() {
			uploader.start();
		});
	});

</script>