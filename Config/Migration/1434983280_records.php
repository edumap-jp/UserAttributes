<?php
/**
 * Insert records migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Insert records migration
 *
 * @package NetCommons\UserAttributes\Config\Migration
 */
class UserAttributesRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Insert records
 *
 * @var array $migration
 */
	public $records = array(
		'UserAttributeSetting' => array(
			array('id' => '1', 'user_attribute_key' => 'avatar', 'data_type_key' => 'img', 'row' => '1', 'col' => '1', 'weight' => '1', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '2', 'user_attribute_key' => 'username', 'data_type_key' => 'text', 'row' => '1', 'col' => '2', 'weight' => '1', 'required' => '1', 'display' => '1', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '1', ),
			array('id' => '3', 'user_attribute_key' => 'password', 'data_type_key' => 'password', 'row' => '1', 'col' => '2', 'weight' => '2', 'required' => '1', 'display' => '1', 'only_administrator_readable' => '1', 'only_administrator_editable' => '0', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '2', ),
			array('id' => '4', 'user_attribute_key' => 'handlename', 'data_type_key' => 'text', 'row' => '1', 'col' => '2', 'weight' => '3', 'required' => '1', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '1', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '3', ),
			array('id' => '5', 'user_attribute_key' => 'name', 'data_type_key' => 'text', 'row' => '1', 'col' => '2', 'weight' => '4', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '1', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '1', 'auto_regist_display' => '1', 'auto_regist_weight' => '4', ),
			array('id' => '6', 'user_attribute_key' => 'email', 'data_type_key' => 'email', 'row' => '1', 'col' => '1', 'weight' => '2', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => '1', 'auto_regist_weight' => '5', ),
			array('id' => '7', 'user_attribute_key' => 'moblie_mail', 'data_type_key' => 'email', 'row' => '1', 'col' => '1', 'weight' => '3', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '1', 'self_email_setting' => '1', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '8', 'user_attribute_key' => 'sex', 'data_type_key' => 'radio', 'row' => '1', 'col' => '1', 'weight' => '4', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '9', 'user_attribute_key' => 'timezone', 'data_type_key' => 'timezone', 'row' => '1', 'col' => '1', 'weight' => '5', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '10', 'user_attribute_key' => 'role_key', 'data_type_key' => 'select', 'row' => '1', 'col' => '1', 'weight' => '6', 'required' => '1', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '1', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '11', 'user_attribute_key' => 'status', 'data_type_key' => 'select', 'row' => '1', 'col' => '1', 'weight' => '7', 'required' => '1', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '12', 'user_attribute_key' => 'created', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '8', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '1', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '13', 'user_attribute_key' => 'created_user', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '9', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '14', 'user_attribute_key' => 'modified', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '10', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '15', 'user_attribute_key' => 'modified_user', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '11', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '16', 'user_attribute_key' => 'password_modified', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '5', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '17', 'user_attribute_key' => 'last_login', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '6', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '1', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '18', 'user_attribute_key' => 'previous_login', 'data_type_key' => 'label', 'row' => '1', 'col' => '2', 'weight' => '7', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '1', 'is_system' => '1', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '0', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '19', 'user_attribute_key' => 'profile', 'data_type_key' => 'textarea', 'row' => '2', 'col' => '1', 'weight' => '1', 'required' => '0', 'display' => '1', 'only_administrator_readable' => '0', 'only_administrator_editable' => '0', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '1', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
			array('id' => '20', 'user_attribute_key' => 'search_keywords', 'data_type_key' => 'text', 'row' => '2', 'col' => '1', 'weight' => '2', 'required' => '0', 'display' => '0', 'only_administrator_readable' => '1', 'only_administrator_editable' => '1', 'is_system' => '0', 'display_label' => '1', 'display_search_result' => '0', 'self_public_setting' => '0', 'self_email_setting' => '0', 'is_multilingualization' => '1', 'auto_regist_display' => null, 'auto_regist_weight' => '9999', ),
		),
		'UserAttributeLayout' => array(
			array('id' => '1', 'col' => '2'),
			array('id' => '2', 'col' => '1'),
			array('id' => '3', 'col' => '1'),
		),
		'UserAttribute' => array(
			//日本語
			array('id' => '1', 'language_id' => '2', 'key' => 'avatar', 'name' => 'アバター', 'description' => '指定しない場合、ハンドルから自動的に生成します。'),
			array('id' => '2', 'language_id' => '2', 'key' => 'username', 'name' => 'ログインID', ),
			array('id' => '3', 'language_id' => '2', 'key' => 'password', 'name' => 'パスワード', ),
			array('id' => '4', 'language_id' => '2', 'key' => 'handlename', 'name' => 'ハンドル', ),
			array('id' => '5', 'language_id' => '2', 'key' => 'name', 'name' => '氏名', ),
			array('id' => '6', 'language_id' => '2', 'key' => 'email', 'name' => 'eメール', ),
			array('id' => '7', 'language_id' => '2', 'key' => 'moblie_mail', 'name' => '携帯メール', ),
			array('id' => '8', 'language_id' => '2', 'key' => 'sex', 'name' => '性別', ),
			array('id' => '9', 'language_id' => '2', 'key' => 'timezone', 'name' => 'タイムゾーン', ),
			array('id' => '10', 'language_id' => '2', 'key' => 'role_key', 'name' => '権限', ),
			array('id' => '11', 'language_id' => '2', 'key' => 'status', 'name' => '状態', ),
			array('id' => '12', 'language_id' => '2', 'key' => 'created', 'name' => '作成日時', ),
			array('id' => '13', 'language_id' => '2', 'key' => 'created_user', 'name' => '作成者', ),
			array('id' => '14', 'language_id' => '2', 'key' => 'modified', 'name' => '更新日時', ),
			array('id' => '15', 'language_id' => '2', 'key' => 'modified_user', 'name' => '更新者', ),
			array('id' => '16', 'language_id' => '2', 'key' => 'password_modified', 'name' => 'パスワード変更日時', ),
			array('id' => '17', 'language_id' => '2', 'key' => 'last_login', 'name' => '最終ログイン日時', ),
			array('id' => '18', 'language_id' => '2', 'key' => 'previous_login', 'name' => '前回ログイン日時', ),
			array('id' => '19', 'language_id' => '2', 'key' => 'profile', 'name' => 'プロフィール', ),
			array('id' => '20', 'language_id' => '2', 'key' => 'search_keywords', 'name' => '検索キーワード', ),
			//英語
			array('id' => '21', 'language_id' => '1', 'key' => 'avatar', 'name' => 'Avatar', 'description' => 'If you do not specify, automatically generates from the handle.'),
			array('id' => '22', 'language_id' => '1', 'key' => 'username', 'name' => 'ID', ),
			array('id' => '23', 'language_id' => '1', 'key' => 'password', 'name' => 'Password', ),
			array('id' => '24', 'language_id' => '1', 'key' => 'handlename', 'name' => 'Handle', ),
			array('id' => '25', 'language_id' => '1', 'key' => 'name', 'name' => 'Name', ),
			array('id' => '26', 'language_id' => '1', 'key' => 'email', 'name' => 'E-mail', ),
			array('id' => '27', 'language_id' => '1', 'key' => 'moblie_mail', 'name' => 'Mobile mail', ),
			array('id' => '28', 'language_id' => '1', 'key' => 'sex', 'name' => 'Sex', ),
			array('id' => '29', 'language_id' => '1', 'key' => 'timezone', 'name' => 'TimeZone', ),
			array('id' => '30', 'language_id' => '1', 'key' => 'role_key', 'name' => 'Authority', ),
			array('id' => '31', 'language_id' => '1', 'key' => 'status', 'name' => 'Status', ),
			array('id' => '32', 'language_id' => '1', 'key' => 'created', 'name' => 'Created', ),
			array('id' => '33', 'language_id' => '1', 'key' => 'created_user', 'name' => 'Creator', ),
			array('id' => '34', 'language_id' => '1', 'key' => 'modified', 'name' => 'Last modified', ),
			array('id' => '35', 'language_id' => '1', 'key' => 'modified_user', 'name' => 'Updater', ),
			array('id' => '36', 'language_id' => '1', 'key' => 'password_modified', 'name' => 'Password has been changed', ),
			array('id' => '37', 'language_id' => '1', 'key' => 'last_login', 'name' => 'Last login', ),
			array('id' => '38', 'language_id' => '1', 'key' => 'previous_login', 'name' => 'Previous login', ),
			array('id' => '39', 'language_id' => '1', 'key' => 'profile', 'name' => 'Profile', ),
			array('id' => '40', 'language_id' => '1', 'key' => 'search_keywords', 'name' => 'Keywords', ),
		),
		'UserAttributeChoice' => array(
			//日本語--性別
			array('language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_no_setting', 'name' => '設定しない', 'code' => 'no_setting', 'weight' => '1', ),
			array('language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_male', 'name' => '男', 'code' => 'male', 'weight' => '2', ),
			array('language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_female', 'name' => '女', 'code' => 'female', 'weight' => '3', ),
			//英語--性別
			array('language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_no_setting', 'name' => 'No setting', 'code' => 'no_setting', 'weight' => '1', ),
			array('language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_male', 'name' => 'Male', 'code' => 'male', 'weight' => '2', ),
			array('language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_female', 'name' => 'Female', 'code' => 'female', 'weight' => '3', ),
			//日本語--状態
			array('language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_1', 'name' => '利用可能', 'code' => '1', 'weight' => '1', ),
			array('language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_0', 'name' => '利用不可', 'code' => '0', 'weight' => '2', ),
			array('language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_2', 'name' => '承認待ち', 'code' => '2', 'weight' => '3', ),
			array('language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_3', 'name' => '承認済み', 'code' => '3', 'weight' => '4', ),
			//英語--状態
			array('language_id' => '1', 'user_attribute_id' => '31', 'key' => 'status_1', 'name' => 'Active', 'code' => '1', 'weight' => '1', ),
			array('language_id' => '1', 'user_attribute_id' => '31', 'key' => 'status_0', 'name' => 'Nonactive', 'code' => '0', 'weight' => '2', ),
			array('language_id' => '1', 'user_attribute_id' => '31', 'key' => 'status_2', 'name' => 'Waiting', 'code' => '2', 'weight' => '3', ),
			array('language_id' => '1', 'user_attribute_id' => '31', 'key' => 'status_3', 'name' => 'Not yet logged-in', 'code' => '3', 'weight' => '4', ),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		$UserAttribute = $this->generateModel('UserAttribute');
		if ($UserAttribute->find('count') > 0) {
			return true;
		}
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
