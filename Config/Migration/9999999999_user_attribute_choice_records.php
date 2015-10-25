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
class UserAttributeChoiceRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'user_attribute_choice_records';

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
		'UserAttributeChoice' => array(
			//日本語--性別
			array('language_id' => '2', 'user_attribute_id' => '9', 'key' => 'sex_no_setting', 'name' => '設定しない', 'code' => 'no_setting', 'weight' => '1', ),
			array('language_id' => '2', 'user_attribute_id' => '9', 'key' => 'sex_male', 'name' => '男', 'code' => 'male', 'weight' => '2', ),
			array('language_id' => '2', 'user_attribute_id' => '9', 'key' => 'sex_female', 'name' => '女', 'code' => 'female', 'weight' => '3', ),
			//英語--性別
			array('language_id' => '1', 'user_attribute_id' => '29', 'key' => 'sex_no_setting', 'name' => 'No setting', 'code' => 'no_setting', 'weight' => '1', ),
			array('language_id' => '1', 'user_attribute_id' => '29', 'key' => 'sex_male', 'name' => 'Male', 'code' => 'male', 'weight' => '2', ),
			array('language_id' => '1', 'user_attribute_id' => '29', 'key' => 'sex_female', 'name' => 'Female', 'code' => 'female', 'weight' => '3', ),
			//日本語--状態
			array('language_id' => '2', 'user_attribute_id' => '12', 'key' => 'status_1', 'name' => '利用可能', 'code' => '1', 'weight' => '1', ),
			array('language_id' => '2', 'user_attribute_id' => '12', 'key' => 'status_0', 'name' => '利用不可', 'code' => '0', 'weight' => '2', ),
			array('language_id' => '2', 'user_attribute_id' => '12', 'key' => 'status_2', 'name' => '承認待ち', 'code' => '2', 'weight' => '3', ),
			array('language_id' => '2', 'user_attribute_id' => '12', 'key' => 'status_3', 'name' => '承認済み', 'code' => '3', 'weight' => '4', ),
			//英語--状態
			array('language_id' => '1', 'user_attribute_id' => '32', 'key' => 'status_1', 'name' => 'Active', 'code' => '1', 'weight' => '1', ),
			array('language_id' => '1', 'user_attribute_id' => '32', 'key' => 'status_0', 'name' => 'Nonactive', 'code' => '0', 'weight' => '2', ),
			array('language_id' => '1', 'user_attribute_id' => '32', 'key' => 'status_2', 'name' => 'Waiting', 'code' => '2', 'weight' => '3', ),
			array('language_id' => '1', 'user_attribute_id' => '32', 'key' => 'status_3', 'name' => 'Not yet logged-in', 'code' => '3', 'weight' => '4', ),
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
