<?php

class FeedbackQuestion extends AppModel {

	public $belongsTo = 'Hotel';
	public $hasMany = 'FeedbackQuestionOption';

}