<?php
/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');
App::uses('UserAttributeChoiceFixture', 'UserAttributes.Test/Fixture');

/**
 * beforeSave()とafterSave()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeChoice
 */
class UserAttributeChoiceSaveTest extends NetCommonsModelTestCase {

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
	protected $_modelName = 'UserAttributeChoice';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'save';

/**
 * save()のテスト(編集)
 *
 * @return void
 */
	public function testSave() {
		//データ生成
		$data['UserAttributeChoice'] = (new UserAttributeChoiceFixture())->records[0];

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertEquals($result['UserAttributeChoice']['key'], $data['UserAttributeChoice']['key']);
		$this->assertEquals($result['UserAttributeChoice']['code'], $data['UserAttributeChoice']['code']);
	}

/**
 * save()のテスト(新規)
 *
 * @return void
 */
	public function testNewSave() {
		//データ生成
		$data['UserAttributeChoice'] = (new UserAttributeChoiceFixture())->records[0];
		$data['UserAttributeChoice'] = Hash::insert($data['UserAttributeChoice'], 'id', null);
		$data['UserAttributeChoice'] = Hash::insert($data['UserAttributeChoice'], 'key', null);
		$data['UserAttributeChoice'] = Hash::insert($data['UserAttributeChoice'], 'code', '');

		//テスト実施
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$result = $this->$model->$methodName($data);

		//チェック
		$this->assertNotEmpty($result['UserAttributeChoice']['key']);
		$this->assertNotEmpty($result['UserAttributeChoice']['code']);
		$this->assertEquals($result['UserAttributeChoice']['key'], $result['UserAttributeChoice']['code']);
	}

}
