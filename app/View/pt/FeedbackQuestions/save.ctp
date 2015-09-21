<h1>Cadastro de pergunta para <?php echo $hotel['User']['name']; ?></h1>

<?php

	echo $this->Form->create('FeedbackQuestion', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));

	echo $this->Form->input('id', array('type' => 'hidden'));
	echo $this->Form->input('hotel_id', array('type' => 'hidden', 'value' => $hotel['Hotel']['id']));
	echo $this->Form->input('question', array('label' => 'Pergunta:'));

	echo '<div id="question-options-box">';
	if (isset($question)) {
		foreach ($question['FeedbackQuestionOption'] as $i => $option) {
			echo '<div class="input">';
			echo $this->Form->input(
				'FeedbackQuestionOption.'.$i.'.id',
				array('type' => 'hidden')
			);
			echo $this->Form->input(
				'FeedbackQuestionOption.'.$i.'.question_option',
				array(
					'label' => 'Opção:',
					'class' => 'question-option-input',
					'data-id' => $option['id'],
					'data-index' => $i,
					'div' => false
				)
			);
			echo $this->Form->input(
				'FeedbackQuestionOption.'.$i.'.order_index',
				array(
					'type' => 'text',
					'label' => 'Ordem:',
					'class' => 'question-option-order-input',
					'div' => false
				)
			);
			echo $this->Html->link(
				'Remover',
				'javascript:void(0)',
				array('class' => 'remove-option')
			);
			echo '</div>';
		}
	}
	echo '</div>';

	echo $this->Html->link(
		'+ Adicionar pergunta',
		'javascript:void(0)',
		array('id' => 'add-question')
	);

	echo $this->Form->submit('Cadastrar');

	echo $this->Form->end();

?>

<script>
	
	$(document).ready(function() {

		$('#add-question').click(function() {
			var $lastOption = $('.question-option-input').last();
			var newIndex = parseInt($lastOption.data('index')) + 1;
			var newOrderIndex = parseInt(
				$lastOption.parent().find('.question-option-order-input').first().val()
				|| newIndex
			) + 1;

			var $newOption = $('<div class="input"></div>');
			$newOption.append(
				'<label for="FeedbackQuestionOption'+newIndex+'QuestionOption">Opção:</label>'
			);
			$newOption.append(
				'<textarea name="data[FeedbackQuestionOption]['+newIndex+'][question_option]" id="FeedbackQuestionOption'+newIndex+'QuestionOption" class="question-option-input" data-index="'+newIndex+'"></textarea>'
			);
			$newOption.append(
				'<input name="data[FeedbackQuestionOption]['+newIndex+'][order_index]" class="question-option-order-input" type="text" value="'+newIndex+'" id="FeedbackQuestionOption'+newIndex+'OrderIndex">'
			);
			$newOption.append(
				'<a href="javascript:void(0)" class="remove-option">Remover</a>'
			);
			$('#question-options-box').append($newOption);
		});

		$('#question-options-box').on('click', '.remove-option', function() {
			var $optionDiv = $(this).parent();
			var optionId = $optionDiv.find('.question-option-input').first().data('id');
			if (!optionId) {
				$optionDiv.remove();
			}
			else if (confirm('Essa opção já foi usada em algumas respostas. Todas serão perdidas. Remover a opção mesmo assim?')) {
				$.ajax({
					url: wr+'feedback_question_options/delete',
					type: 'DELETE',
					data: {id: optionId},
					success: function() {
						$optionDiv.remove();
					}
				});
			}
		});

	});

</script>