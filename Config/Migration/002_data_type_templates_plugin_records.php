<?php
/**
 * Add DataTypeTemplatesPlugin migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Add DataTypeTemplatesPlugin migration
 *
 * @package NetCommons\UserAttributes\Config\Migration
 */
class DataTypeTemplatesPluginRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'data_type_templates_plugin_records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * plugin data
 *
 * @var array $migration
 */
	public $records = array(
		'DataTypeTemplatesPlugin' => array(
			array('data_type_template_key' => 'text', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'textarea', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'radio', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'checkbox', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'select', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'email', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'img', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'file', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'date', 'plugin_key' => 'user_attributes', ),
			array('data_type_template_key' => 'refecture_select', 'plugin_key' => 'user_attributes', ),
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
		if ($direction === 'down') {
			return true;
		}
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
