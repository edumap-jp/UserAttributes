<?php
/**
 * UserAttributeSetting::saveUserAttributeWeight()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeSetting::saveUserAttributeWeight()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeSetting
 */
class UserAttributeSettingSaveUserAttributeWeightTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_choice',
		'plugin.user_attributes.user_attribute_layout',
		'plugin.user_attributes.user_attribute_setting4test',
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
	protected $_methodName = 'saveUserAttributeWeight';

/**
 * saveUserAttributeWeight()のテスト
 *
 * @return void
 */
	public function testSaveUserAttributeWeight() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//期待値のデータ取得
		$expected = $this->$model->find('all', array(
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$expected = Hash::combine($expected, '{n}.UserAttributeSetting.id', '{n}');
		$expected = Hash::remove($expected, '5.UserAttributeSetting.modified');
		$expected = Hash::remove($expected, '5.UserAttributeSetting.modified_user');
		$expected['5']['UserAttributeSetting']['weight'] = '6';
		$expected['16']['UserAttributeSetting']['weight'] = '4';
		$expected['17']['UserAttributeSetting']['weight'] = '5';

		//データ生成
		$data = array(
			'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'col' => '2', 'weight' => '6')
		);

		//テスト実施
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertTrue($result);

		$actual = $this->$model->find('all', array(
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$actual = Hash::combine($actual, '{n}.UserAttributeSetting.id', '{n}');
		$actual = Hash::remove($actual, '5.UserAttributeSetting.modified');
		$actual = Hash::remove($actual, '5.UserAttributeSetting.modified_user');

		$this->assertEquals($expected, $actual);
	}

/**
 * データエラーのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 存在しないID
			array(array(
				'UserAttributeSetting' => array('id' => '999', 'row' => '1', 'col' => '2', 'weight' => '6')
			)),
			// * rowが数値以外
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'row' => 'aa', 'col' => '2', 'weight' => '6')
			)),
			// * rowがない
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'col' => '2', 'weight' => '6')
			)),
			// * colが数値以外
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'col' => 'a', 'weight' => '6')
			)),
			// * colがない
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'weight' => '6')
			)),
			// * weightが数値以外
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'col' => '2', 'weight' => 'a')
			)),
			// * weightがない
			array(array(
				'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'col' => '2')
			)),
		);
	}

/**
 * データエラーのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProvider
 * @return void
 */
	public function testDataError($data) {
		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertFalse($result);
	}

/**
 * ErrorExceptionのテスト
 *
 * @return void
 */
	public function testErrorException() {
		$this->_mockForReturnFalse('UserAttributeSetting', 'UserAttributes.UserAttributeSetting', 'save');

		$this->setExpectedException('InternalErrorException');
		//データ生成
		$data = array(
			'UserAttributeSetting' => array('id' => '5', 'row' => '1', 'col' => '2', 'weight' => '6')
		);

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$this->$model->$methodName($data);
	}

}
