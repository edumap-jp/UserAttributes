<?php
/**
 * UserAttributesController::edit()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeSetting4editFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttribute4editFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributesController::edit()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\UserAttributesController
 */
class UserAttributesControllerEditTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.plugin4test',
		'plugin.user_attributes.plugins_role4test',
		'plugin.user_attributes.user_attribute4edit',
		'plugin.user_attributes.user_attribute_choice4edit',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4edit',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'user_attributes';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'user_attributes';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * テストデータセット
 *
 * @return void
 */
	private function __data() {
		$data = array(
			'UserAttributeSetting' => (new UserAttributeSetting4editFixture())->records[0],
			'UserAttribute' => array(
				0 => (new UserAttribute4editFixture())->records[0],
				1 => (new UserAttribute4editFixture())->records[1],
			),
		);

		return $data;
	}

/**
 * edit()アクションのGETパラメータテスト
 *
 * @return void
 */
	public function testEditGet() {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'key' => 'user_attribute_key'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertTextContains('ng-controller="UserAttributes"', $this->view);
		$this->assertInput('form', null, 'user_attributes/user_attributes/edit/user_attribute_key', $this->view);
		$this->assertTextContains('user_attributes/user_attributes/delete', $this->view);
		$this->assertEquals($this->controller->UserAttributeSetting->addDataTypes, $this->controller->DataTypeForm->dataTypes);

		$this->assertArrayHasKey('UserAttribute', $this->controller->data);
		$this->assertCount(2, $this->controller->data['UserAttribute']);
		$this->assertArrayHasKey('key', $this->controller->data['UserAttribute'][1]);
		$this->assertArrayHasKey('key', $this->controller->data['UserAttribute'][2]);
		$this->assertArrayHasKey('UserAttributeSetting', $this->controller->data);
		$this->assertArrayHasKey('user_attribute_key', $this->controller->data['UserAttributeSetting']);
	}

/**
 * edit()アクションのGETパラメータテスト(選択肢がある)
 *
 * @return void
 */
	public function testEditGetRadio() {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'key' => 'radio_attribute_key'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, 'user_attributes/user_attributes/edit/radio_attribute_key', $this->view);
	}

/**
 * edit()アクションのGETパラメータテスト(システムフィールド)
 *
 * @return void
 */
	public function testEditGetBySystemField() {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'key' => 'system_attribute_key'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertTextContains('ng-controller="UserAttributes"', $this->view);
		$this->assertInput('form', null, 'user_attributes/user_attributes/edit/system_attribute_key', $this->view);
		$this->assertTextNotContains('user_attributes/user_attributes/delete', $this->view);
		$this->assertEquals($this->controller->UserAttributeSetting->editDataTypes, $this->controller->DataTypeForm->dataTypes);
	}

/**
 * edit()アクションのGETパラメータ(不正アクセス)テスト
 *
 * @return void
 */
	public function testEditGetOnExceptionError() {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'key' => 'aaaaa'), null, 'BadRequestException', 'view');
	}

/**
 * edit()アクションのGETパラメータ(不正アクセス)テスト(JSON形式)
 *
 * @return void
 */
	public function testEditGetOnExceptionErrorJson() {
		//テスト実行
		$this->_testGetAction(array('action' => 'edit', 'key' => 'aaaaa'), null, 'BadRequestException', 'json');
	}

/**
 * edit()のPOSTアクションのテスト
 *
 * @return void
 */
	public function testEditPost() {
		$this->_mockForReturnTrue('UserAttributes.UserAttributeChoice', 'validateRequestData');
		$this->_mockForReturnTrue('UserAttributes.UserAttribute', 'saveUserAttribute');

		//テスト実行
		$data = $this->__data();
		$this->_testPostAction('put', $data, array('action' => 'edit', 'key' => 'user_attribute_key'), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$this->assertTextContains('/user_attributes/user_attributes/index', $header['Location']);
	}

/**
 * UserAttributeChoice->validateRequestData()のエラー発生テスト
 *
 * @return void
 */
	public function testEditPostChoiceValidateError() {
		$this->_mockForReturnFalse('UserAttributes.UserAttributeChoice', 'validateRequestData');

		//テスト実行
		$data = $this->__data();
		$this->_testPostAction('put', $data, array('action' => 'edit', 'key' => 'user_attribute_key'), 'BadRequestException', 'view');
	}

/**
 * UserAttributeChoice->validateRequestData()のエラー発生テスト(JSON形式)
 *
 * @return void
 */
	public function testEditdPostChoiceValidateErrorJson() {
		$this->_mockForReturnFalse('UserAttributes.UserAttributeChoice', 'validateRequestData');

		//テスト実行
		$data = $this->__data();
		$this->_testPostAction('put', $data, array('action' => 'edit', 'key' => 'user_attribute_key'), 'BadRequestException', 'json');
	}

/**
 * UserAttribute->validationErrorsのテスト
 *
 * @return void
 */
	public function testEditPostValidateError() {
		$this->_mockForReturn('UserAttributes.UserAttributeChoice', 'validateRequestData', null);

		//テスト実行
		$data = $this->__data();
		$data = Hash::remove($data, 'UserAttribute.{n}.name');
		$this->_testPostAction('put', $data, array('action' => 'edit', 'key' => 'user_attribute_key'), null, 'view');

		//チェック
		$this->assertTextContains('ng-controller="UserAttributes"', $this->view);
		$this->assertInput('form', null, 'user_attributes/user_attributes/edit/user_attribute_key', $this->view);
		$this->assertTextContains('user_attributes/user_attributes/delete', $this->view);
		$this->assertEquals($this->controller->UserAttributeSetting->addDataTypes, $this->controller->DataTypeForm->dataTypes);
		$this->assertTextContains(
			sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item name')),
			$this->view
		);
	}

}
