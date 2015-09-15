<h1>Avalie nosso hotel</h1>

<?php
	echo $this->Form->create('FeedbackAnswerList');

	foreach ($hotel['FeedbackQuestion'] as $i => $question) {
		echo $this->Form->input('FeedbackAnswer.'.$i.'.feedback_question_id', array('type' => 'hidden', 'value' => $question['id']));
		
		$options = array();
		foreach ($question['FeedbackQuestionOption'] as $option) {
			// XXX: Logic in view!
			// TODO: find a better approach to create options array
			$options[$option['id']] = $option['question_option'];
		}
		echo $this->Form->radio('FeedbackAnswer.'.$i.'.feedback_question_option_id', $options, array('separator' => '<br>', 'legend' => $question['question']));
	}

	echo $this->Form->submit('Concluir');
	echo $this->Form->end();
?>