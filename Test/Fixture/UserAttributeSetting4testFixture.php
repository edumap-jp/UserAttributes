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

App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 * @codeCoverageIgnore
 */
class UserAttributeSetting4testFixture extends UserAttributeSettingFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'UserAttributeSetting';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'user_attribute_settings';

/**
 * Records
 *
 * @var array
 */
	public $records = array();

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();

		require_once App::pluginPath('UserAttributes') . 'Config' . DS . 'Migration' . DS . '1434983280_records.php';
		$records = (new UserAttributesRecords())->records[$this->name];
		$this->records = array_merge($this->records, $records);

		require_once App::pluginPath('UserAttributes') . 'Config' . DS . 'Migration' . DS . '1434983282_add_language_records.php';
		$records = (new AddLanguageRecords())->records[$this->name];
		$this->records = array_merge($this->records, $records);
	}

}
