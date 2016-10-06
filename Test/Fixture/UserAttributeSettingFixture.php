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
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'user_attribute_key' => 'user_attribute_key',
			'data_type_key' => 'text',
			'row' => '1',
			'col' => '1',
			'weight' => '1',
			'required' => true,
			'display' => true,
			'only_administrator_readable' => true,
			'only_administrator_editable' => true,
			'is_system' => false,
			'display_label' => true,
			'display_search_result' => true,
			'self_public_setting' => true,
			'self_email_setting' => false,
			'is_multilingualization' => true,
			'auto_regist_display' => null,
			'auto_regist_weight' => '9999',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('UserAttributes') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new UserAttributesSchema())->tables[Inflector::tableize($this->name)];
		parent::init();
	}

}
