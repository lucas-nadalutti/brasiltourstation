<h1>Questionário de <?php echo $hotel['User']['name']; ?></h1>

<?php

	echo '<ul>';
	foreach ($hotel['FeedbackQuestion'] as $question) {
		echo '<li>' . $question['question'] . ' ';
		echo $this->Html->link(
			'Editar',
			array('action' => 'save', $hotel['Hotel']['id'], $question['id'])
		);
		echo '<ul>';

		foreach ($question['FeedbackQuestionOption'] as $option) {
			echo '<li>' . $option['question_option'] . '</li>';
		}
		echo '</ul>';
		echo '</li>';
	}
	echo '</ul>';

	echo '<div>';
	echo $this->Html->link(
		'Cadastrar pergunta',
		array('action' => 'save', $hotel['Hotel']['id'])
	);
	echo '</div>';

?>