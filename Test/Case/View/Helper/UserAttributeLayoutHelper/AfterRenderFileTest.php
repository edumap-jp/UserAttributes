<?php
/**
 * UserAttributeLayoutHelper::afterRenderFile()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeLayoutHelper::afterRenderFile()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Controller\Component\UserAttributeLayoutHelper
 */
class UserAttributeLayoutHelperAfterRenderFileTest extends NetCommonsControllerTestCase {

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
 * afterRenderFile()のテスト
 *
 * @return void
 */
	public function testAfterRenderFile() {
		//テストコントローラ生成
		$this->generateNc('TestUserAttributes.TestUserAttributeLayoutHelperAfterRenderFile');

		//テスト実行
		$this->_testNcAction('/test_user_attributes/test_user_attribute_layout_helper_after_render_file/index', null);

		//チェック
		$pattern = '/' . preg_quote('View/Helper/TestUserAttributeLayoutHelperAfterRenderFile', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/user_attributes/css/style.css', '/') . '.*?>/';
	}

}
