<?php
/**
 * UserAttributeHelper::moveSettingTopMenu()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeLayoutFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeHelper::moveSettingTopMenu()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\View\Helper\UserAttributeHelper
 */
class UserAttributeHelperMoveSettingTopMenuTest extends NetCommonsHelperTestCase {

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
 * moveSettingTopMenu()のテストチェック
 *
 * @param string $result テスト結果
 * @param int $userAttrSettingId UserAttributeSetting.id
 * @param int $updRow 更新する段
 * @param int $updCol 更新する列
 * @param int $updWeight 更新する順序
 * @param bool $disabled disabledかどうか
 * @return void
 */
	private function __assertMoveSettingTopMenu($result, $userAttrSettingId, $updRow, $updCol, $updWeight, $disabled) {
		$formName = 'UserAttributeMoveForm' . $userAttrSettingId . 'Top';
		//チェック
		if ($disabled) {
			$this->assertContains('<li class="disabled">', $result);
			$this->assertNotContains('<a href="" onclick="$(\'form[name=' . $formName . ']\')[0].submit()">', $result);
		} else {
			$this->assertNotContains('<li class="disabled">', $result);
			$this->assertContains('<a href="" onclick="$(\'form[name=' . $formName . ']\')[0].submit()">', $result);
		}
		$this->assertContains('<span class="glyphicon glyphicon-arrow-up">' . __d('user_attributes', 'Go to Up') . '</span>', $result);
		$this->assertInput('form', $formName, '/user_attribute_settings/move/' . $userAttrSettingId, $result);
		$this->assertInput('input', '_method', 'PUT', $result);
		$this->assertInput('input', 'data[UserAttributeSetting][id]', $userAttrSettingId, $result);
		$this->assertInput('input', 'data[UserAttributeSetting][row]', $updRow, $result);
		$this->assertInput('input', 'data[UserAttributeSetting][col]', $updCol, $result);
		$this->assertInput('input', 'data[UserAttributeSetting][weight]', $updWeight, $result);
	}

/**
 * moveSettingTopMenu()のテスト
 * [レイアウト＝2列、順序＝先頭]
 *
 * @return void
 */
	public function testLayout2AndWeight1() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);

		//データ生成
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$userAttribute = Hash::get($viewVars['userAttributes'], '1.1.1');

		//テスト実施
		$result = $this->UserAttribute->moveSettingTopMenu($layout, $userAttribute);

		//チェック
		$this->__assertMoveSettingTopMenu($result, '1', '1', '1', '1', true);
	}

/**
 * moveSettingTopMenu()のテスト
 * [レイアウト＝2列、順序＝真ん中]
 *
 * @return void
 */
	public function testLayout2AndWeight2() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);

		//データ生成
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$userAttribute = Hash::get($viewVars['userAttributes'], '1.1.2');

		//テスト実施
		$result = $this->UserAttribute->moveSettingTopMenu($layout, $userAttribute);

		//チェック
		$this->__assertMoveSettingTopMenu($result, '2', '1', '1', '1', false);
	}

/**
 * moveSettingTopMenu()のテスト
 * [レイアウト＝1列、順序＝真ん中]
 *
 * @return void
 */
	public function testLayout1AndWeight1() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$viewVars['userAttributeLayouts']['1'] = '1';

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);

		//データ生成
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$layout['UserAttributeLayout']['col'] = $viewVars['userAttributeLayouts']['1'];
		$userAttribute = Hash::get($viewVars['userAttributes'], '1.1.1');

		//テスト実施
		$result = $this->UserAttribute->moveSettingTopMenu($layout, $userAttribute);

		//チェック
		$this->__assertMoveSettingTopMenu($result, '1', '1', '1', '1', true);
	}

/**
 * moveSettingTopMenu()のテスト
 * [レイアウト＝1列、順序＝2列目の先頭(全て2列)。レイアウトを2列から1列に途中から変更した場合]
 *
 * @return void
 */
	public function testLayout1AndCol2AndWeight1AndNoRow1() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$viewVars['userAttributeLayouts']['1'] = '1';
		$viewVars['userAttributes'] = Hash::insert($viewVars['userAttributes'], '{n}.{n}.{n}.UserAttributeSetting.col', '2');
		$viewVars['userAttributes'][1][2] = $viewVars['userAttributes'][1][1];
		unset($viewVars['userAttributes'][1][1]);

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);

		//データ生成
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$layout['UserAttributeLayout']['col'] = $viewVars['userAttributeLayouts']['1'];
		$userAttribute = Hash::get($viewVars['userAttributes'], '1.2.1');

		//テスト実施
		$result = $this->UserAttribute->moveSettingTopMenu($layout, $userAttribute);

		//チェック
		$this->__assertMoveSettingTopMenu($result, '1', '1', '1', '1', true);
	}

/**
 * moveSettingTopMenu()のテスト
 * [レイアウト＝1列、順序＝2列目の先頭。レイアウトを2列から1列に途中から変更した場合]
 *
 * @return void
 */
	public function testLayout1AndCol2AndWeight1() {
		//テストデータ生成
		$viewVars = $this->__viewVars;
		$viewVars['userAttributeLayouts']['1'] = '1';
		$viewVars['userAttributes'] = Hash::insert($viewVars['userAttributes'], '1.1.2.UserAttributeSetting.col', '2');
		$viewVars['userAttributes'] = Hash::insert($viewVars['userAttributes'], '1.1.2.UserAttributeSetting.weight', '1');
		$viewVars['userAttributes'][1][2][1] = $viewVars['userAttributes'][1][1][2];
		unset($viewVars['userAttributes'][1][1][2]);
		$viewVars['userAttributes'] = Hash::insert($viewVars['userAttributes'], '1.1.3.UserAttributeSetting.weight', '2');

		$requestData = array();

		//Helperロード
		$this->loadHelper('UserAttributes.UserAttribute', $viewVars, $requestData);

		//データ生成
		$layout['UserAttributeLayout'] = (new UserAttributeLayoutFixture())->records[0];
		$layout['UserAttributeLayout']['col'] = $viewVars['userAttributeLayouts']['1'];
		$userAttribute = Hash::get($viewVars['userAttributes'], '1.2.1');

		//テスト実施
		$result = $this->UserAttribute->moveSettingTopMenu($layout, $userAttribute);

		//チェック
		$this->__assertMoveSettingTopMenu($result, '2', '1', '1', '2', false);
	}

}
