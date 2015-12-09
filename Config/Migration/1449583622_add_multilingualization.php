<?php
/**
 * Migration file
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration file
 *
 * * user_attribute_settingsに「多言語化にする」の有無のフィールド(multilingualization)を追加
 *
 * @package NetCommons\UserAttributes\Config\Migration
 * @link https://github.com/NetCommons3/UserAttributes/issues/15
 */
class AddMultilingualization extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Add_multilingualization';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'user_attribute_settings' => array(
					'multilingualization' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「多言語にする」の有無', 'after' => 'self_email_setting'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'user_attribute_settings' => array('multilingualization'),
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
