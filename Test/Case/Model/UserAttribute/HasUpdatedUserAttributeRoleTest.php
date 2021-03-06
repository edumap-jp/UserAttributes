<?php
/**
 * UserAttribute::hasUpdatedUserAttributeRole()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttribute::hasUpdatedUserAttributeRole()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttribute
 */
class UserAttributeHasUpdatedUserAttributeRoleTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'hasUpdatedUserAttributeRole';

/**
 * テストデータセット
 *
 * @param bool $isNew 新規かどうか
 * @return void
 */
	private function __data($isNew) {
		if ($isNew) {
			$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
			$data['UserAttributeSetting'] = Hash::insert($data['UserAttributeSetting'], 'id', null);
			$data['UserAttributeSetting'] = Hash::insert($data['UserAttributeSetting'], 'user_attribute_key', null);
		} else {
			$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];
		}

		return $data;
	}

/**
 * hasUpdatedUserAttributeRole()のテスト用DataProvider
 *
 * ### 戻り値
 *  - before 登録前データ
 *  - data 登録データ
 *  - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		$data = $this->__data(false);

		return array(
			// * 新規データ
			array(array(), $this->__data(true), true),
			// * only_administrator_readable=false
			array($data, Hash::merge($data, array('UserAttributeSetting' => array('only_administrator_readable' => false))), true),
			// * only_administrator_editable=false
			array($data, Hash::merge($data, array('UserAttributeSetting' => array('only_administrator_editable' => false))), true),
			// * only_administrator_readable、only_administrator_editable以外が変更
			array($data, Hash::merge($data, array('UserAttributeSetting' => array('required' => true))), false),
		);
	}

/**
 * hasUpdatedUserAttributeRole()のテスト
 *
 * @param array $before 登録前データ
 * @param array $data 登録データ
 * @param bool $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testHasUpdatedUserAttributeRole($before, $data, $expected) {
		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($before, $data);

		//チェック
		$this->assertEquals($expected, $result);
	}
}
