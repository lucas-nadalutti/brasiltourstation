<h1>Upload de Vídeo</h1>

<?php

	echo $this->Form->create('Video', array('id' => 'video-uploading-form', 'type' => 'file', 'inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));
	echo $this->Form->input('name', array('label' => 'Título:'));

	echo '<div>';
	echo '<p id="video-file"></p>';
	echo $this->Html->link(
		'Escolher Vídeo',
		'javascript:void(0);',
		array('id' => 'browse')
	);
	echo '</div>';

	echo $this->Form->hidden('url', array('id' => 'target-url'));
	echo $this->Form->hidden('type', array('id' => 'file-type'));

	echo '<div>';
	echo $this->Html->link(
		'Salvar Vídeo',
		'javascript:void(0);',
		array('id' => 'start-upload'));
	echo '</div>';

	echo $this->Form->end();

?>

<div id="upload-errors"></div>
 
<script type="text/javascript">
	$(document).ready(function() {
		var uploader = new plupload.Uploader({
			browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
			url: wr+'videos/uploadVideoFile',
			chunk_size: '2mb',
    		max_retries: 3,
    		unique_names: true,
    		multi_selection: false,
    		filters: [
            	{
            		title: 'Videos only',
            		extensions: 'mp4',
            	}
        	],
		});

		uploader.init();

		uploader.bind('FilesAdded', function(up, files) {
			// only 1 file will be added, always
			var currentFile = files[0];
			// if other files were previously chosen, erase them from the queue
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
			var $targetUrlInput = $('#video-uploading-form').find('#target-url');
			var $fileTypeInput = $('#video-uploading-form').find('#file-type');
			$targetUrlInput.val(file.target_name);
			$fileTypeInput.val(file.type);
			$('#video-uploading-form').submit();
		});

		uploader.bind('Error', function(up, err) {
			$('#upload-errors').append('<p>Error #' + err.code + ': ' + err.message + '</p>');
		});

		$('#start-upload').click(function() {
			uploader.start();
		});
	});
</script>