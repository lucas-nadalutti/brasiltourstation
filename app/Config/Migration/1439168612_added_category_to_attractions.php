<?php
class AddedCategoryToAttractions extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_category_to_attractions';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'attractions' => array(
					'category' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'name'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'attractions' => array('category'),
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
