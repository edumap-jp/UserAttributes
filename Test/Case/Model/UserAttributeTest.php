<?php
/**
 * UserAttribute Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttribute', 'UserAttributes.Model');

/**
 * Summary for UserAttribute Test Case
 */
class UserAttributeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute',
		//'plugin.user_attributes.language',
		//'plugin.user_attributes.user',
		//'plugin.user_attributes.role',
		//'plugin.user_attributes.plugin',
		//'plugin.user_attributes.plugins_role',
		//'plugin.user_attributes.room',
		//'plugin.user_attributes.space',
		//'plugin.user_attributes.spaces_language',
		//'plugin.user_attributes.rooms_language',
		//'plugin.user_attributes.roles_room',
		//'plugin.user_attributes.user_attribute_choice',
		//'plugin.user_attributes.user_attributes_role',
		//'plugin.user_attributes.user_attributes_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserAttribute);

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
