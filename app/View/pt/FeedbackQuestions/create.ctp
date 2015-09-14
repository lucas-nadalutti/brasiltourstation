<h1>Cadastro de pergunta para <?php echo $hotel['User']['name']; ?></h1>

<?php

	echo $this->Form->create('FeedbackQuestion', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));

	echo $this->Form->input('hotel_id', array('type' => 'hidden', 'value' => $hotel['Hotel']['id']));
	echo $this->Form->input('question', array('label' => 'Pergunta:'));

	// TODO: Use javascript to make option adding/removing dynamic
	echo $this->Form->input('FeedbackQuestionOption.0.question_option', array('label' => 'Opção 1:'));
	echo $this->Form->input('FeedbackQuestionOption.1.question_option', array('label' => 'Opção 2:'));
	echo $this->Form->input('FeedbackQuestionOption.2.question_option', array('label' => 'Opção 3:'));
	echo $this->Form->input('FeedbackQuestionOption.3.question_option', array('label' => 'Opção 4:'));

	echo $this->Form->submit('Cadastrar');

	echo $this->Form->end();

?>