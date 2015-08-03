<?php
class AddedFieldsToHotel02082015 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_fields_to_hotel_02082015';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'hotels' => array(
					'video_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index', 'after' => 'user_id'),
					'last_life_sign' => array('type' => 'datetime', 'null' => true, 'default' => null, 'after' => 'longitude'),
					'indexes' => array(
						'video_id' => array('column' => 'video_id', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'hotels' => array('video_id', 'last_life_sign', 'indexes' => array('video_id')),
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
