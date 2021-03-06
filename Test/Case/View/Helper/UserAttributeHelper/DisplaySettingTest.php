<?php
/**
 * UserAttributeHelper::displaySetting()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeHelper::displaySetting()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Helper\UserAttributeHelper
 */
class UserAttributeHelperDisplaySettingTest extends NetCommonsHelperTestCase {

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

		//テストデータ生成
		$viewVars = array();
		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);
	}

/**
 * displaySetting()のテスト
 *
 * @return void
 */
	public function testDisplaySetting() {
		//データ生成
		$userAttribute['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];

		//テスト実施
		$result = $this->UserAttribute->displaySetting($userAttribute);

		//チェック
		$this->assertInput('form', null, '/user_attribute_settings/display/1', $result);
		$this->assertInput('input', 'data[UserAttributeSetting][id]', '1', $result);
		$this->assertInput('input', 'data[UserAttributeSetting][display]', null, $result);
		$this->assertContains('glyphicon-eye-open', $result);
		$this->assertNotContains('glyphicon-minus', $result);
		$this->assertContains('btn btn-xs btn-default user-attributes-display-btn active', $result);
	}

/**
 * displaySetting()のテスト(display=false)
 *
 * @return void
 */
	public function testDisplayFalse() {
		//データ生成
		$userAttribute['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
		$userAttribute['UserAttributeSetting']['display'] = false;

		//テスト実施
		$result = $this->UserAttribute->displaySetting($userAttribute);

		//チェック
		$this->assertInput('form', null, '/user_attribute_settings/display/1', $result);
		$this->assertInput('input', 'data[UserAttributeSetting][id]', '1', $result);
		$this->assertInput('input', 'data[UserAttributeSetting][display]', '0', $result);
		$this->assertNotContains('glyphicon-eye-open', $result);
		$this->assertContains('glyphicon-minus', $result);
		$this->assertContains('btn btn-xs btn-default user-attributes-display-btn', $result);
	}

}
