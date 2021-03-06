<?php
/**
 * UserAttributeSettingsController::move()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeSettingsController::move()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\UserAttributeSettingsController
 */
class UserAttributeSettingsControllerMoveTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.plugin4test',
		'plugin.user_attributes.plugins_role4test',
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_choice',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting',
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
	protected $_controller = 'user_attribute_settings';

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
 * 意図したリクエストデータ用DataProvider
 *
 * ### 戻り値
 *  - data POSTデータ
 *
 * @return array
 */
	public function dataProviderSuccess() {
		$results = array();

		//テストデータ
		$results[0] = array('data' => array(
			'UserAttributeSetting' => array('id' => '1', 'row' => '1', 'col' => '2', 'weight' => '3')
		));

		return $results;
	}

/**
 * move()アクションのテスト
 *
 * @param array $data リクエストデータ
 * @dataProvider dataProviderSuccess
 * @return void
 */
	public function testMove($data) {
		$this->_mockForReturnTrue('UserAttributes.UserAttributeSetting', 'saveUserAttributeWeight');

		//テスト実行
		$this->_testPostAction('put', $data, array('action' => 'move'), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$pattern = '/' . preg_quote('/user_attributes/user_attributes/index', '/') . '/';
		$this->assertRegExp($pattern, $header['Location']);
	}

/**
 * UserAttributeSetting->saveUserAttributeWeight()がエラーの場合のテスト
 *
 * @param array $data リクエストデータ
 * @dataProvider dataProviderSuccess
 * @return void
 */
	public function testSaveUserAttributeWeightError($data) {
		$this->_mockForReturnFalse('UserAttributes.UserAttributeSetting', 'saveUserAttributeWeight');

		//テスト実行
		$this->_testPostAction('put', $data, array('action' => 'move'), 'BadRequestException', 'view');
	}

/**
 * UserAttributeSetting->saveUserAttributeWeight()がエラーの場合のテスト(JSON形式)
 *
 * @param array $data リクエストデータ
 * @dataProvider dataProviderSuccess
 * @return void
 */
	public function testSaveUserAttributeWeightErrorJson($data) {
		$this->_mockForReturnFalse('UserAttributes.UserAttributeSetting', 'saveUserAttributeWeight');

		//テスト実行
		$this->_testPostAction('put', $data, array('action' => 'move'), 'BadRequestException', 'json');
	}

/**
 * GETリクエストのテスト
 *
 * @return void
 */
	public function testGet() {
		//テスト実行
		$this->_testGetAction(array('action' => 'move'), null, 'BadRequestException', 'view');
	}

/**
 * GETリクエストのテスト(JSON形式)
 *
 * @return void
 */
	public function testGetJson() {
		//テスト実行
		$this->_testGetAction(array('action' => 'move'), null, 'BadRequestException', 'json');
	}

}
