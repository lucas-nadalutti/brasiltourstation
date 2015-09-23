<?php
class AddedCurrencyQuotesTable extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'added_currency_quotes_table';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'currency_quotes' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'quote_date' => array('type' => 'date', 'null' => false, 'default' => null),
					'dollar' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,4', 'unsigned' => false),
					'dollar_variation' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '5,2', 'unsigned' => false),
					'euro' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,4', 'unsigned' => false),
					'euro_variation' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '5,2', 'unsigned' => false),
					'pound' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,4', 'unsigned' => false),
					'pound_variation' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '5,2', 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'currency_quotes'
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
