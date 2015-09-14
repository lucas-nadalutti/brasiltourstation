<?php

class FeedbackAnswerList extends AppModel {

	public $belongsTo = 'Hotel';
	public $hasMany = 'FeedbackAnswer';

}