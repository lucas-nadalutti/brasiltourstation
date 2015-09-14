<h1>Cadastro de pergunta para <?php echo $hotel['User']['name']; ?></h1>

<?php

	echo $this->Form->create('FeedbackQuestion', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));

	echo $this->Form->input('hotel_id', array('type' => 'hidden', 'value' => $hotel['Hotel']['id']));
	echo $this->Form->input('question', array('label' => 'Pergunta:'));

	// TODO: Use javascript to make option adding/removing dynamic
	if (isset($question)) {
		foreach ($question['FeedbackQuestionOption'] as $i => $option) {
			echo $this->Form->input('FeedbackQuestionOption.'.$i.'.id', array('type' => 'hidden'));
			echo $this->Form->input('FeedbackQuestionOption.'.$i.'.question_option', array('label' => 'Opção:', 'data-id' => $option['id']));
		}
	}

	echo $this->Form->submit('Cadastrar');

	echo $this->Form->end();

?>