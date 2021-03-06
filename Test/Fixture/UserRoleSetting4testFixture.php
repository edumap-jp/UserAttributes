<?php
/**
 * UserRoleSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserRoleSettingFixture', 'UserRoles.Test/Fixture');

/**
 * UserRoleSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Model
 */
class UserRoleSetting4testFixture extends UserRoleSettingFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'UserRoleSetting';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'user_role_settings';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array('role_key' => 'system_administrator', 'origin_role_key' => 'system_administrator', 'use_private_room' => '1', ),
		array('role_key' => 'administrator', 'origin_role_key' => 'administrator', 'use_private_room' => '1', ),
		array('role_key' => 'common_user', 'origin_role_key' => 'common_user', 'use_private_room' => '1', ),
	);

}
