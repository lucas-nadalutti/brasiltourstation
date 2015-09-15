<?php
class AddedOrderIndexToQuestion extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_order_index_to_question';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'feedback_question_options' => array(
					'order_index' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'after' => 'question_option'),
				),
				'feedback_questions' => array(
					'order_index' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'after' => 'question'),
				),
			),
			'drop_field' => array(
				'feedback_questions' => array('order'),
			),
		),
		'down' => array(
			'drop_field' => array(
				'feedback_question_options' => array('order_index'),
				'feedback_questions' => array('order_index'),
			),
			'create_field' => array(
				'feedback_questions' => array(
					'order' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
