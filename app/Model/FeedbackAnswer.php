<?php

class FeedbackAnswer extends AppModel {

	public $belongsTo = 'FeedbackAnswerList';
	public $hasMany = array('FeedbackQuestion', 'FeedbackQuestionOption');

}