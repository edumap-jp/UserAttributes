<?php
/**
 * UserAttributeSetting::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeSetting::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Case\Model\UserAttributeSetting
 */
class UserAttributeSettingValidateTest extends NetCommonsValidateTest {

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
		$data['UserAttributeSetting'] = (new UserAttributeSettingFixture())->records[0];

		return array(
			array('data' => $data, 'field' => 'user_attribute_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'data_type_key', 'value' => '',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'data_type_key', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'row', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'col', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'weight', 'value' => 'aaaa',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'required', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'only_administrator_readable', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'only_administrator_editable', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'display_label', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'self_public_setting', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'self_email_setting', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_multilingualization', 'value' => 2,
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
