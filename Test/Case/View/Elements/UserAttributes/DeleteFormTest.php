<?php
/**
 * View/Elements/UserAttributes/delete_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/UserAttributes/delete_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Elements\UserAttributes\DeleteForm
 */
class UserAttributesViewElementsUserAttributesDeleteFormTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'user_attributes';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'UserAttributes', 'TestUserAttributes');
	}

/**
 * View/Elements/UserAttributes/delete_formのテスト
 *
 * @return void
 */
	public function testDeleteForm() {
		//テストコントローラ生成
		$this->generateNc('TestUserAttributes.TestViewElementsUserAttributesDeleteForm');

		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_delete_form/delete_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/UserAttributes/delete_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('form', null, 'user_attributes/user_attributes/delete', $this->view);
		$this->assertInput('input', 'data[UserAttributeSetting][user_attribute_key]', 'user_attribute_key', $this->view);
		$this->assertInput('button', 'delete', null, $this->view);
	}

}
