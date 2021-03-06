<?php
/**
 * UserAttribute::getUserAttributesForLayout()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * UserAttribute::getUserAttributesForLayout()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttribute
 */
class UserAttributeGetUserAttributesForLayoutTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.data_types.data_type4test',
		'plugin.data_types.data_type_choice4test',
		'plugin.user_attributes.user_attribute4test',
		'plugin.user_attributes.user_attribute_choice4test',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4test',
		'plugin.user_attributes.user_attributes_role4test',
		'plugin.user_attributes.user_role_setting4test',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'user_attributes';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'UserAttribute';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getUserAttributesForLayout';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Current::$current['User']['role_key'] = UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR;
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
 * データエラーのDataProvider
 *
 * ### 戻り値
 *  - force 強制的に取得するフラグ
 *  - userAttributes static変数の初期値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 強制的に取得するフラグ = false, static変数の初期値 = null
			array('force' => false, 'userAttributes' => null),
			// * 強制的に取得するフラグ = true, static変数の初期値 = null
			array('force' => true, 'userAttributes' => null),
			// * 強制的に取得するフラグ = true, static変数の初期値 = array('dummy')
			array('force' => true, 'userAttributes' => array('dummy')),
			// * 強制的に取得するフラグ = false, static変数の初期値 = array('dummy')については、
			//   testGetUserAttributesForLayout2で実施
		);
	}

/**
 * getUserAttributesForLayout()のテスト
 *
 * @param bool $force 強制的に取得するフラグ
 * @param array|null $userAttributes static変数の初期値
 * @dataProvider dataProvider
 */
	public function testGetUserAttributesForLayout($force, $userAttributes) {
		//static変数の初期化
		UserAttribute::$userAttributes = $userAttributes;

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($force);

		//チェック
		// * rowのチェック
		$this->assertCount(2, $result);
		// * colのチェック
		$this->assertCount(2, $result[1]);
		$this->assertCount(1, $result[2]);
		// * weightのチェック
		$this->assertCount(7, $result[1][1]);
		$this->assertCount(11, $result[1][2]);
		$this->assertCount(2, $result[2][1]);
		// * データのチェック(例：氏名)
		$this->__assertText($result);
		// * データのチェック(例：権限)
		$this->__assertRoleKey($result);
		// * データチェック(例：タイムゾーン)
		$this->__assertDataTypeChoice($result);
		// * データチェック(例：性別)
		$this->__assertUserAttributeChoice($result);
	}

/**
 * 選択肢以外のチェック(例：氏名(UserAttribute.key=name))
 *
 * @param array $result テスト結果
 * @dataProvider dataProvider
 */
	private function __assertText($result) {
		$actual = Hash::get($result, '1.2.4');
		$this->assertEquals(
			array('UserAttribute', 'UserAttributeSetting', 'UserAttributesRole'),
			array_keys($actual)
		);
		$this->assertEquals('5', $actual['UserAttribute']['id']);
		$this->assertEquals('name', $actual['UserAttribute']['key']);
		$this->assertEquals('name', $actual['UserAttributeSetting']['user_attribute_key']);
		$this->assertEquals('text', $actual['UserAttributeSetting']['data_type_key']);
		$this->assertEquals(UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR, $actual['UserAttributesRole']['role_key']);
		$this->assertEquals('name', $actual['UserAttributesRole']['user_attribute_key']);
	}

/**
 * 会員権限のチェック(UserAttribute.key=role_key)
 *
 * @param array $result テスト結果
 * @dataProvider dataProvider
 */
	private function __assertRoleKey($result) {
		$actual = Hash::get($result, '1.1.6');
		$this->assertEquals(
			array('UserAttribute', 'UserAttributeSetting', 'UserAttributesRole', 'UserAttributeChoice'),
			array_keys($actual)
		);
		$this->assertEquals('10', $actual['UserAttribute']['id']);
		$this->assertEquals('role_key', $actual['UserAttribute']['key']);
		$this->assertEquals('role_key', $actual['UserAttributeSetting']['user_attribute_key']);
		$this->assertEquals('select', $actual['UserAttributeSetting']['data_type_key']);
		$this->assertEquals(UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR, $actual['UserAttributesRole']['role_key']);
		$this->assertEquals('role_key', $actual['UserAttributesRole']['user_attribute_key']);
		$this->assertEquals(
			array(
				1 => array(
					'id' => '1', 'language_id' => '2', 'key' => 'system_administrator',
					'name' => 'System administrator', 'user_attribute_id' => '10'
				),
				2 => array(
					'id' => '2', 'language_id' => '2', 'key' => 'administrator',
					'name' => 'Site administrator', 'user_attribute_id' => '10'
				),
				3 => array(
					'id' => '3', 'language_id' => '2', 'key' => 'common_user',
					'name' => 'Common user', 'user_attribute_id' => '10'
				)
			),
			$actual['UserAttributeChoice']
		);
	}

/**
 * データタイプが選択肢のチェック(例：タイムゾーン((UserAttribute.key=timezone)))
 *
 * @param array $result テスト結果
 * @dataProvider dataProvider
 */
	private function __assertDataTypeChoice($result) {
		$actual = Hash::get($result, '1.1.5');
		$this->assertEquals(
			array('UserAttribute', 'UserAttributeSetting', 'UserAttributesRole', 'UserAttributeChoice'),
			array_keys($actual)
		);
		$this->assertEquals('9', $actual['UserAttribute']['id']);
		$this->assertEquals('timezone', $actual['UserAttribute']['key']);
		$this->assertEquals('timezone', $actual['UserAttributeSetting']['user_attribute_key']);
		$this->assertEquals('select', $actual['UserAttributeSetting']['data_type_key']);
		$this->assertEquals(UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR, $actual['UserAttributesRole']['role_key']);
		$this->assertEquals('timezone', $actual['UserAttributesRole']['user_attribute_key']);
		//$this->DataType->getDataTypes()の戻り値に依存し、
		//getDataTypes()でテストされているはずで、ここでは配列の型のみチェックする
		$this->assertInternalType('array', $actual['UserAttributeChoice']);
	}

/**
 * UserAttributeが選択肢のチェック(例：性別((UserAttribute.key=sex)))
 *
 * @param array $result テスト結果
 * @dataProvider dataProvider
 */
	private function __assertUserAttributeChoice($result) {
		$actual = Hash::get($result, '1.1.4');
		$this->assertEquals(
			array('UserAttribute', 'UserAttributeSetting', 'UserAttributesRole', 'UserAttributeChoice'),
			array_keys($actual)
		);
		$this->assertEquals('8', $actual['UserAttribute']['id']);
		$this->assertEquals('sex', $actual['UserAttribute']['key']);
		$this->assertEquals('sex', $actual['UserAttributeSetting']['user_attribute_key']);
		$this->assertEquals('radio', $actual['UserAttributeSetting']['data_type_key']);
		$this->assertEquals(UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR, $actual['UserAttributesRole']['role_key']);
		$this->assertEquals('sex', $actual['UserAttributesRole']['user_attribute_key']);
		$this->assertCount(3, $actual['UserAttributeChoice']);
		$this->assertEquals('sex_no_setting', $actual['UserAttributeChoice'][1]['key']);
		$this->assertEquals('sex_male', $actual['UserAttributeChoice'][2]['key']);
		$this->assertEquals('sex_female', $actual['UserAttributeChoice'][3]['key']);
	}

/**
 * 強制的に取得するフラグ = false, static変数の初期値 = array('dummy')のテスト
 *
 * @return void
 */
	public function testGetUserAttributesForLayout2() {
		//データ生成
		$force = false;

		//static変数の変更
		$userAttributes = UserAttribute::$userAttributes;
		UserAttribute::$userAttributes = array('dummy');

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($force);

		//チェック
		$this->assertEquals($result, UserAttribute::$userAttributes);

		//static変数を戻す(以降のテストが'dummy'で動作しないように)
		UserAttribute::$userAttributes = $userAttributes;
	}

}
