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
 * Summary for UserAttributeSettingFixture
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
		'data_type_template_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'row' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'col' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '表示順'),
		'required' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'display' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'only_administrator' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'is_systemized' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'display_label' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'display_search_list' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'self_publicity' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'self_email_reception_possibility' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'data_type_template_key' => 'Lorem ipsum dolor sit amet',
			'row' => 1,
			'col' => 1,
			'weight' => 1,
			'required' => 1,
			'display' => 1,
			'only_administrator' => 1,
			'is_systemized' => 1,
			'display_label' => 1,
			'display_search_list' => 1,
			'self_publicity' => 1,
			'self_email_reception_possibility' => 1,
			'created_user' => 1,
			'created' => '2015-08-05 08:35:08',
			'modified_user' => 1,
			'modified' => '2015-08-05 08:35:08'
		),
	);

}
