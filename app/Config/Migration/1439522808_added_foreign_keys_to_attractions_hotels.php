<?php
class AddedForeignKeysToAttractionsHotels extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_foreign_keys_to_attractions_hotels';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'attractions_hotels' => array(
					'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
				),
			),
			'create_field' => array(
				'attractions_hotels' => array(
					'indexes' => array(
						'hotel_id' => array('column' => 'hotel_id', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'attractions_hotels' => array(
					'hotel_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
				),
			),
			'drop_field' => array(
				'attractions_hotels' => array('indexes' => array('hotel_id')),
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
