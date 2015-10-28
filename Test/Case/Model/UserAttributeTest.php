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
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		//$this->UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//($this->UserAttribute);

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
