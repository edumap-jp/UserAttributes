<?php
/**
 * UserAttributeSetting::updateDisplay()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeSetting::updateDisplay()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeSetting
 */
class UserAttributeSettingUpdateDisplayTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'UserAttributeSetting';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'updateDisplay';

/**
 * updateDisplay()のテスト
 *
 * @return void
 */
	public function testUpdateDisplay() {
		//データ生成
		$data = array(
			'UserAttributeSetting' => array('id' => '1', 'display' => 0)
		);
		$fieldName = 'display';

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data, $fieldName);

		//チェック
		$this->assertTrue($result);
		$actual = $this->$model->find('first', array('recursive' => -1,
			'conditions' => array('id' => $data['UserAttributeSetting']['id'])
		));
		$this->assertEquals($data['UserAttributeSetting']['display'], $actual['UserAttributeSetting']['display']);
	}

/**
 * データエラーのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - fieldName フィールド名
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 存在しないID
			array(array('UserAttributeSetting' => array('id' => '99', 'display' => 1)), 'display'),
			// * 存在しないフィールド
			array(array('UserAttributeSetting' => array('id' => '1', 'aaaa' => 1)), 'aaaa'),
			// * displayフィールド以外
			array(array('UserAttributeSetting' => array('id' => '1', 'only_administrator_readable' => 1)), 'only_administrator_readable'),
			// * 数値以外
			array(array('UserAttributeSetting' => array('id' => '1', 'display' => 'aaaa')), 'display'),
			// * 0,1以外
			array(array('UserAttributeSetting' => array('id' => '1', 'display' => '2')), 'display'),
		);
	}

/**
 * データエラーのテスト
 *
 * @param array $data 登録データ
 * @param string $fieldName フィールド名
 * @dataProvider dataProvider
 * @return void
 */
	public function testDataError($data, $fieldName) {
		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data, $fieldName);

		//チェック
		$this->assertFalse($result);
	}

/**
 * ErrorExceptionのテスト
 *
 * @return void
 */
	public function testErrorException() {
		$this->_mockForReturnFalse('UserAttributeSetting', 'UserAttributes.UserAttributeSetting', 'saveField');

		$this->setExpectedException('InternalErrorException');
		//データ生成
		$data = array(
			'UserAttributeSetting' => array('id' => '1', 'display' => 0)
		);
		$fieldName = 'display';

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->$model->$methodName($data, $fieldName);
	}

}
