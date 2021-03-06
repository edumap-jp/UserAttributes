<?php
/**
 * View/Elements/UserAttributes/choice_edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/UserAttributes/choice_edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Elements\UserAttributes\ChoiceEditForm
 */
class UserAttributesViewElementsUserAttributesChoiceEditFormTest extends NetCommonsControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestUserAttributes.TestViewElementsUserAttributesChoiceEditForm');
	}

/**
 * View/Elements/UserAttributes/choice_edit_formのテスト
 *
 * @return void
 */
	public function testChoiceEdit() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_choice_edit_form/choice_edit_form',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/UserAttributes/choice_edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[UserAttributeChoiceMap][2][id]', '2', $this->view);
		$this->assertInput('input', 'data[UserAttributeChoiceMap][2][language_id]', '1', $this->view);
		$this->assertInput('input', 'data[UserAttributeChoiceMap][2][user_attribute_id]', '8', $this->view);
		$this->assertInput('input', 'data[UserAttributeChoiceMap][2][key]', 'sex_male', $this->view);
		$this->assertInput('input', 'data[UserAttributeChoiceMap][2][code]', 'male', $this->view);
	}

/**
 * View/Elements/UserAttributes/choice_edit_formのテスト
 *
 * @return void
 */
	public function testChoiceEditFormNull() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_choice_edit_form/choice_edit_form_null',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/UserAttributes/choice_edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('data[UserAttributeChoiceMap][2][id]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);
	}

/**
 * UserAttributeChoice.id項目がないのテスト
 *
 * @return void
 */
	public function testChoiceEditFormFormWOId() {
		//テスト実行
		$this->_testGetAction('/test_user_attributes/test_view_elements_user_attributes_choice_edit_form/choice_edit_form_without_id',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/UserAttributes/choice_edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '/' . preg_quote('data[UserAttributeChoiceMap][2][id]', '/') . '/';
		$this->assertNotRegExp($pattern, $this->view);
	}

}
