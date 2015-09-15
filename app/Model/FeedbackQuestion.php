<?php

class FeedbackQuestion extends AppModel {

	public $belongsTo = 'Hotel';
	public $hasMany = array(
		'FeedbackQuestionOption' => array(
			'order' => 'FeedbackQuestionOption.order_index',
		)
	);
}