<?php
/**
 * UserAttributeLayoutHelper::renderCol()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeLayoutFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeLayout', 'UserAttributes.Model');
class_exists('UserAttributeLayout'); // phpunitでエラーになるため

/**
 * UserAttributeLayoutHelper::renderCol()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Helper\UserAttributeLayoutHelper
 */
class UserAttributeLayoutHelperRenderColTest extends NetCommonsHelperTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute4edit',
		'plugin.user_attributes.user_attribute_choice4edit',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4edit',
		'plugin.user_roles.user_attributes_role4edit',
		'plugin.user_attributes.user_role_setting4test',
	);

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
		Current::$current['User']['role_key'] = UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR;

		//テストデータ生成
		$UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
		$UserAttributeLayout = ClassRegistry::init('UserAttributes.UserAttributeLayout');

		UserAttribute::$userAttributes = null;
		$this->__viewVars['userAttributes'] = $UserAttribute->getUserAttributesForLayout();
		$this->__viewVars['userAttributeLayouts'] = $UserAttributeLayout->find('all', array(
			'fields' => array('id', 'col'),
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Current::$current['User']['role_key'] = null;
		parent::tearDown();
	}

/**
 * renderCol()のテスト(レイアウト＝2列、データ＝1,2列あり)
 *
 * @return void
 */
	public function testLayout2AndCol1AndCol2() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$viewVars['userAttributes'][1][2][1] = $viewVars['userAttributes'][1][1][3];
		$viewVars['userAttributes'][1][2][1]['UserAttributeSetting']['col'] = '1';
		$viewVars['userAttributes'][1][2][1]['UserAttributeSetting']['weight'] = '1';
		unset($viewVars['userAttributes'][1][1][3]);

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttributeLayout', $viewVars, $requestData);

		//データ生成
		$elementFile = 'UserAttributes/render_index_col';
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];

		//テスト実施
		$result = $this->UserAttributeLayout->renderCol($elementFile, $layout);

		//チェック
		$this->assertEquals(2, preg_match_all('/' . preg_quote('<div class="col-xs-12 col-sm-6">', '/') . '/', $result));

		$actual = preg_split('/' . preg_quote('<div class="col-xs-12 col-sm-6">', '/') . '/', $result);
		$this->assertNotEmpty(substr($actual[1], 0, -1 * strlen('</div>')));
		$this->assertNotEmpty(substr($actual[2], 0, -1 * strlen('</div>')));
	}

/**
 * renderCol()のテスト(レイアウト＝2列、データ＝1列目のみ)
 *
 * @return void
 */
	public function testLayout2AndCol1() {
		//テストデータ生成
		$viewVars = $this->__viewVars;

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttributeLayout', $viewVars, $requestData);

		//データ生成
		$elementFile = 'UserAttributes/render_index_col';
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];

		//テスト実施
		$result = $this->UserAttributeLayout->renderCol($elementFile, $layout);

		//チェック
		$this->assertEquals(2, preg_match_all('/' . preg_quote('<div class="col-xs-12 col-sm-6">', '/') . '/', $result));

		$actual = preg_split('/' . preg_quote('<div class="col-xs-12 col-sm-6">', '/') . '/', $result);
		$this->assertNotEmpty(substr($actual[1], 0, -1 * strlen('</div>')));
		$this->assertEmpty(substr($actual[2], 0, -1 * strlen('</div>')));
	}

/**
 * renderCol()のテスト(レイアウト＝2列、データ＝2列目のみ)
 *
 * @return void
 */
	public function testLayout2AndCol2() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$viewVars['userAttributes'][1][2] = $viewVars['userAttributes'][1][1];
		$viewVars['userAttributes'][1][2] = Hash::insert($viewVars['userAttributes'][1][2], '{n}.UserAttributeSetting.col', '2');
		unset($viewVars['userAttributes'][1][1]);

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttributeLayout', $viewVars, $requestData);

		//データ生成
		$elementFile = 'UserAttributes/render_index_col';
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];

		//テスト実施
		$result = $this->UserAttributeLayout->renderCol($elementFile, $layout);

		//チェック
		$this->assertNotContains('<div class="col-xs-12 col-sm-6">', $result);
		$this->assertContains('<div class="col-xs-12 col-sm-offset-6 col-sm-6">', $result);
	}

/**
 * renderCol()のテスト(レイアウト＝0列、データ＝1,2列あり)
 *
 * @return void
 */
	public function testLayout0() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttributeLayout', $viewVars, $requestData);

		//データ生成
		$elementFile = 'UserAttributes/render_index_col';
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$layout['UserAttributeLayout']['col'] = 0;

		//テスト実施
		$result = $this->UserAttributeLayout->renderCol($elementFile, $layout);

		//チェック
		$this->assertEmpty($result);
	}

}
