<?php
/**
 * UserAttributeSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * UserAttributeSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 */
class UserAttributeSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_attribute_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data_type_key' => array('type' => 'string', 'null' => false, 'default' => 'text', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'row' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'col' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '表示順'),
		'required' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「必須項目とする」の有無'),
		'display' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '表示の有無'),
		'only_administrator_readable' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「本人も読めない（管理者のみ読める）」の有無'),
		'only_administrator_editable' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「本人も書けない（管理者のみ書ける）」の有無'),
		'is_system' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'システム項目かどうか'),
		'display_label' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '「項目名を表示する」の有無'),
		'display_search_result' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「検索結果リストに表示する（デフォルト）」の有無。画面からの設定は不可'),
		'self_public_setting' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「各自で公開・非公開の設定可能にする」の有無'),
		'self_email_setting' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '「各自でメールの受信可否を設定可能にする」の有無'),
		'is_multilingualization' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'comment' => '「多言語にする」の有無'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_attribute_key' => 'Lorem ipsum dolor sit amet',
			'data_type_key' => 'Lorem ipsum dolor sit amet',
			'row' => 1,
			'col' => 1,
			'weight' => 1,
			'required' => 1,
			'display' => 1,
			'only_administrator_readable' => 1,
			'only_administrator_editable' => 1,
			'is_system' => 1,
			'display_label' => 1,
			'display_search_result' => 1,
			'self_public_setting' => 1,
			'self_email_setting' => 1,
			'is_multilingualization' => 1,
			'created_user' => 1,
			'created' => '2015-08-05 08:35:08',
			'modified_user' => 1,
			'modified' => '2015-08-05 08:35:08'
		),
	);

}
