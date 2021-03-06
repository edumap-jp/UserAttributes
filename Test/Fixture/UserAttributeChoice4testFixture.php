<?php
/**
 * UserAttributeChoiceFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributeChoiceFixture', 'UserAttributes.Test/Fixture');

/**
 * UserAttributeChoiceFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\Fixture
 * @codeCoverageIgnore
 */
class UserAttributeChoice4testFixture extends UserAttributeChoiceFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'UserAttributeChoice';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'user_attribute_choices';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//日本語--性別
		array('id' => 1, 'language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_no_setting', 'name' => '設定しない', 'code' => 'no_setting', 'weight' => '1', ),
		array('id' => 2, 'language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_male', 'name' => '男', 'code' => 'male', 'weight' => '2', ),
		array('id' => 3, 'language_id' => '2', 'user_attribute_id' => '8', 'key' => 'sex_female', 'name' => '女', 'code' => 'female', 'weight' => '3', ),
		//英語--性別
		array('id' => 4, 'language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_no_setting', 'name' => 'No setting', 'code' => 'no_setting', 'weight' => '1', ),
		array('id' => 5, 'language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_male', 'name' => 'Male', 'code' => 'male', 'weight' => '2', ),
		array('id' => 6, 'language_id' => '1', 'user_attribute_id' => '28', 'key' => 'sex_female', 'name' => 'Female', 'code' => 'female', 'weight' => '3', ),
		//日本語--状態
		array('id' => 7, 'language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_1', 'name' => '利用可能', 'code' => '1', 'weight' => '1', ),
		array('id' => 8, 'language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_0', 'name' => '利用不可', 'code' => '0', 'weight' => '2', ),
		array('id' => 9, 'language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_2', 'name' => '承認待ち', 'code' => '2', 'weight' => '3', ),
		array('id' => 10, 'language_id' => '2', 'user_attribute_id' => '11', 'key' => 'status_3', 'name' => '承認済み', 'code' => '3', 'weight' => '4', ),
	);

}
