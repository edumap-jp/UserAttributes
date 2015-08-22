<?php
/**
 * DefaultUserRole Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');

/**
 * DefaultUserRole Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserRoles\Model\Behavior
 */
class UserAttributeBehavior extends ModelBehavior {

/**
 * Save default UserAttributeRoles
 *
 * @param Model $model Model using this behavior
 * @param array $data User role data
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveDefaultUserAttributeRoles(Model $model, $data) {
		$model->loadModels([
			'UserRoleSetting' => 'UserRoles.UserRoleSetting',
			'UserAttributesRole' => 'UserRoles.UserAttributesRole',
			'PluginsRole' => 'PluginManager.PluginsRole',
		]);

		$pluginsRoles = $model->PluginsRole->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'plugin_key' => 'user_manager',
			)
		));

		$userRoleSettings = $model->UserRoleSetting->find('all', array('recursive' => -1));

		foreach ($userRoleSettings as $userRoleSetting) {
			$params = array(
				'role_key' => $userRoleSetting['UserRoleSetting']['role_key'],
				'origin_role_key' => $userRoleSetting['UserRoleSetting']['origin_role_key'],
				'user_attribute_key' => $data['UserAttributeSetting']['user_attribute_key'],
				'only_administrator' => (bool)$data['UserAttributeSetting']['only_administrator'],
				'is_systemized' => (bool)$data['UserAttributeSetting']['is_systemized']
			);

			$params['is_usable_user_manager'] =
					(bool)Hash::extract($pluginsRoles, '{n}.PluginsRole[role_key=' . $params['role_key'] . ']');

			$userAttributeRole = $model->UserAttributesRole->defaultUserAttributeRolePermissions($params);
			if (! $model->UserAttributesRole->save($userAttributeRole, array('validate' => false))) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

}
