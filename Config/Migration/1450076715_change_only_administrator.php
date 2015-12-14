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
 * * 会員管理者以外の読み書きを禁ずる」を「本人も読めない」「本人も書けない」に分割する
 *
 * @package NetCommons\UserAttributes\Config\Migration
 * @link https://github.com/NetCommons3/UserAttributes/issues/20
 */
class ChangeOnlyAdministrator extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_only_administrator';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'user_attribute_settings' => array(
					'only_administrator_readable' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「本人も読めない（管理者のみ読める）」の有無', 'after' => 'display'),
					'only_administrator_editable' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「本人も書けない（管理者のみ書ける）」の有無', 'after' => 'only_administrator_readable'),
				),
			),
			'drop_field' => array(
				'user_attribute_settings' => array('only_administrator'),
			),
		),
		'down' => array(
			'drop_field' => array(
				'user_attribute_settings' => array('only_administrator_readable', 'only_administrator_editable'),
			),
			'create_field' => array(
				'user_attribute_settings' => array(
					'only_administrator' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「管理者以外の読み書きを禁ずる」の有無'),
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
