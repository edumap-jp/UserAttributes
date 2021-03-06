<?php
/**
 * UserAttributeChoice::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('UserAttributeChoiceFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeChoice::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeChoice
 */
class UserAttributeChoiceValidateTest extends NetCommonsValidateTest {

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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['UserAttributeChoice'] = (new UserAttributeChoiceFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'language_id', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'language_id', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'user_attribute_id', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'user_attribute_id', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'name', 'value' => null,
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item choice name'))),
			array('data' => $data, 'field' => 'name', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item choice name'))),
			array('data' => $data, 'field' => 'key', 'value' => null,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'weight', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
