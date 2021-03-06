<?php
/**
 * UserAttribute::validateUserAttribute()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeChoiceFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttribute::validateUserAttribute()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttribute
 */
class UserAttributeValidateUserAttributeTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
	protected $_methodName = 'validateUserAttribute';

/**
 * テストデータセット
 *
 * @param string $type 入力タイプ
 * @param string $unsetModel unsetするモデル名
 * @return void
 */
	private function __data($type = 'text', $unsetModel = null) {
		if ($type === 'text') {
			$data['UserAttribute'] = (new UserAttributeFixture())->records;
			$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
			$data['UserAttributeChoice'] = array();
		} else {
			$data['UserAttribute'] = (new UserAttributeFixture())->records;
			$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
			$data['UserAttributeSetting']['data_type_key'] = $type;
			$data['UserAttributeChoice'] = (new UserAttributeChoiceFixture())->records;
		}

		if ($unsetModel) {
			unset($data[$unsetModel]);
		}
		return $data;
	}

/**
 * validateUserAttribute()のテスト
 *
 * @return void
 */
	public function testValidateUserAttribute() {
		//データ生成
		$data = $this->__data();

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertTrue($result);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return array テストデータ
 */
	public function dataProviderValidateUserAttributeOnFailure() {
		return array(
			array($this->__data('text'), 'UserAttributes.UserAttribute', 'validateMany'),
			array($this->__data('text'), 'UserAttributes.UserAttributeSetting'),
			array($this->__data('select'), 'UserAttributes.UserAttributeChoice', 'validateMany'),
			array($this->__data('text', 'UserAttribute'), 'UserAttributes.UserAttribute', null),
			array($this->__data('text', 'UserAttributeSetting'), 'UserAttributes.UserAttributeSetting', null),
			array($this->__data('select', 'UserAttributeChoice'), 'UserAttributes.UserAttributeChoice', null),
		);
	}

/**
 * SaveのValidationErrorテスト
 *
 * @param array $data 登録データ
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @dataProvider dataProviderValidateUserAttributeOnFailure
 * @return void
 */
	public function testValidateUserAttributeOnFailure($data, $mockModel, $mockMethod = 'validates') {
		$model = $this->_modelName;
		$method = $this->_methodName;

		if ($mockMethod) {
			$this->_mockForReturnFalse($model, $mockModel, $mockMethod);
		}
		$result = $this->$model->$method($data);
		$this->assertFalse($result);
	}

}
