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
 * フィールド名を変更
 * * is_systemized -> is_system
 * * display_search_list -> display_search_result
 * * self_publicity -> self_public_setting
 * * self_email_reception_possibility -> self_email_setting
 *
 * @package NetCommons\UserAttributes\Config\Migration
 * @link https://github.com/NetCommons3/UserAttributes/issues/14
 */
class RenameFields extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'rename_fields';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'user_attribute_settings' => array(
					'is_system' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'システム項目かどうか', 'after' => 'only_administrator'),
					'display_search_result' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「検索結果リストに表示する（デフォルト）」の有無。画面からの設定は不可', 'after' => 'display_label'),
					'self_public_setting' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「各自で公開・非公開の設定可能にする」の有無', 'after' => 'display_search_result'),
					'self_email_setting' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「各自でメールの受信可否を設定可能にする」の有無', 'after' => 'self_public_setting'),
				),
			),
			'drop_field' => array(
				'user_attribute_settings' => array('is_systemized', 'display_search_list', 'self_publicity', 'self_email_reception_possibility'),
			),
			'alter_field' => array(
				'user_attribute_settings' => array(
					'required' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「必須項目とする」の有無'),
					'display' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '表示の有無'),
					'only_administrator' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「管理者以外の読み書きを禁ずる」の有無'),
					'display_label' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '「項目名を表示する」の有無'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'user_attribute_settings' => array('is_system', 'display_search_result', 'self_public_setting', 'self_email_setting'),
			),
			'create_field' => array(
				'user_attribute_settings' => array(
					'is_systemized' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => 'システム項目かどうか'),
					'display_search_list' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => '「検索結果リストに表示する（デフォルト）」の有無。画面からの設定は不可'),
					'self_publicity' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => '「各自で公開・非公開の設定可能にする」の有無'),
					'self_email_reception_possibility' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => '「各自でメールの受信可否を設定可能にする」の有無'),
				),
			),
			'alter_field' => array(
				'user_attribute_settings' => array(
					'required' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => '「必須項目とする」の有無'),
					'display' => array('type' => 'boolean', 'null' => true, 'default' => true, 'comment' => '表示の有無'),
					'only_administrator' => array('type' => 'boolean', 'null' => true, 'default' => false, 'comment' => '「管理者以外の読み書きを禁ずる」の有無'),
					'display_label' => array('type' => 'boolean', 'null' => true, 'default' => true, 'comment' => '「項目名を表示する」の有無'),
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
