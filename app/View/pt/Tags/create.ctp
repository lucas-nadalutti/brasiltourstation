<h1>Cadastro de Tag</h1>

<?php

	echo $this->Form->create('Tag', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));

	echo $this->Form->input('name_pt', array('label' => 'Português:', 'class' => 'tag-name'));
	echo $this->Form->input('name_en', array('label' => 'Inglês:', 'class' => 'tag-name'));
	echo $this->Form->input('name_es', array('label' => 'Espanhol:', 'class' => 'tag-name'));

	echo $this->Form->submit('Cadastrar', array('class' => 'green button'));
	
	echo $this->Form->end();

?>

<script>
	$(document).ready(function() {

		// If the typed character is the first one, convert to upper case
		$('.tag-name').keypress(function(event) {
			if ($(this).val().length == 0) {
				$(this).val(String.fromCharCode(event.which).toUpperCase());
				return false;
			}
		});
	});
</script>