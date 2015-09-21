<?php

class FeedbackQuestionOptionsController extends AppController {

	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}

	public function delete() {
		$this->autoRender = false;
		$id = $this->request->data('id');
		$this->FeedbackQuestionOption->delete($id);
	}

}