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
class UserAttributeRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'user_attribute_records';

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
		'UserAttribute' => array(
			//日本語
			array('id' => '1', 'language_id' => '2', 'key' => 'avatar', 'name' => 'アバター', ),
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
			array('id' => '18', 'language_id' => '2', 'key' => 'profile', 'name' => 'プロフィール', ),
			array('id' => '19', 'language_id' => '2', 'key' => 'search_keywords', 'name' => '検索キーワード', ),
			//英語
			array('id' => '20', 'language_id' => '1', 'key' => 'avatar', 'name' => 'Avatar', ),
			array('id' => '21', 'language_id' => '1', 'key' => 'username', 'name' => 'ID', ),
			array('id' => '22', 'language_id' => '1', 'key' => 'password', 'name' => 'Password', ),
			array('id' => '23', 'language_id' => '1', 'key' => 'handlename', 'name' => 'Handle', ),
			array('id' => '24', 'language_id' => '1', 'key' => 'name', 'name' => 'Name', ),
			array('id' => '25', 'language_id' => '1', 'key' => 'email', 'name' => 'E-mail', ),
			array('id' => '26', 'language_id' => '1', 'key' => 'moblie_mail', 'name' => 'Mobile mail', ),
			array('id' => '27', 'language_id' => '1', 'key' => 'sex', 'name' => 'Sex', ),
			array('id' => '28', 'language_id' => '1', 'key' => 'timezone', 'name' => 'TimeZone', ),
			array('id' => '29', 'language_id' => '1', 'key' => 'role_key', 'name' => 'Authority', ),
			array('id' => '30', 'language_id' => '1', 'key' => 'status', 'name' => 'Status', ),
			array('id' => '31', 'language_id' => '1', 'key' => 'created', 'name' => 'Created', ),
			array('id' => '32', 'language_id' => '1', 'key' => 'created_user', 'name' => 'Creator', ),
			array('id' => '33', 'language_id' => '1', 'key' => 'modified', 'name' => 'Last modified', ),
			array('id' => '34', 'language_id' => '1', 'key' => 'modified_user', 'name' => 'Updater', ),
			array('id' => '35', 'language_id' => '1', 'key' => 'password_modified', 'name' => 'Password has been changed', ),
			array('id' => '36', 'language_id' => '1', 'key' => 'last_login', 'name' => 'Last login', ),
			array('id' => '37', 'language_id' => '1', 'key' => 'profile', 'name' => 'Profile', ),
			array('id' => '38', 'language_id' => '1', 'key' => 'search_keywords', 'name' => 'Keywords', ),
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
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
