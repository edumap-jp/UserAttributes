<?php
/**
 * UserAttributeSetting Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributeSetting', 'UserAttributes.Model');

/**
 * Summary for UserAttributeSetting Test Case
 */
class UserAttributeSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute_setting',
		'plugin.users.user',
		//'plugin.user_attributes.role',
		//'plugin.user_attributes.language',
		//'plugin.user_attributes.plugin',
		//'plugin.user_attributes.plugins_role',
		//'plugin.user_attributes.room',
		//'plugin.user_attributes.space',
		//'plugin.user_attributes.spaces_language',
		//'plugin.user_attributes.rooms_language',
		//'plugin.user_attributes.roles_room'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAttributeSetting = ClassRegistry::init('UserAttributes.UserAttributeSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAttributeSetting);

		parent::tearDown();
	}

/**
 * test mock
 *
 * @return void
 */
	public function test() {
	}

}
