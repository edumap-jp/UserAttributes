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

App::uses('DataType', 'DataTypes.Model');
App::uses('ModelBehavior', 'Model');
App::uses('CakeMigration', 'Migrations.Lib');

/**
 * DefaultUserRole Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserRoles\Model\Behavior
 */
class UserAttributeBehavior extends ModelBehavior {

/**
 * Field format
 *
 * @var const
 */
	const
		PUBLIC_FIELD_FORMAT = 'is_%s_public',
		FILE_FIELD_FORMAT = '%s_file_id';

/**
 * UserAttributesRoleのデフォルトデータ登録
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param array $data 登録データ
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
		$userRoleSettings = $model->UserRoleSetting->find('all', array(
			'recursive' => -1
		));

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

/**
 * 会員項目レイアウト用のFindオプション
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @return array findOptions
 */
	public function findOptionsForLayout(Model $model) {
		$options = array(
			'recursive' => -1,
			'fields' => array(
				$model->alias . '.*',
				$model->UserAttributeSetting->alias . '.*',
			),
			'conditions' => array(
				$model->alias . '.language_id' => Current::read('Language.id')
			),
			'joins' => array(
				array(
					'table' => $model->UserAttributeSetting->table,
					'alias' => $model->UserAttributeSetting->alias,
					'type' => 'INNER',
					'conditions' => array(
						$model->UserAttributeSetting->alias . '.user_attribute_key' . ' = ' . $model->alias . ' .key',
					),
				),
			),
			'order' => array(
				$model->UserAttributeSetting->alias . '.row' => 'asc',
				$model->UserAttributeSetting->alias . '.col' => 'asc',
				$model->UserAttributeSetting->alias . '.weight' => 'asc'
			)
		);

		return $options;
	}

/**
 * フィールドの作成
 * ※会員項目の追加で呼び出す
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param array $data 登録データ
 * @return bool Status of the process
 * @throws InternalErrorException
 */
	public function addColumnByUserAttribute(Model $model, $data) {
		$model->loadModels([
			'User' => 'Users.User',
			'UsersLanguage' => 'Users.UsersLanguage',
		]);

		$model->Migration = new CakeMigration(array('connection' => $model->useDbConfig));
		$userAttributeKey = $data[$model->UserAttributeSetting->alias]['user_attribute_key'];

		$schema = array_keys($model->User->schema());
		$userColumn = array_pop($schema);

		//会員項目フィールド
		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_TEXT ||
				$data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_TEXTAREA) {
			$schema = array_keys($model->UsersLanguage->schema());
			$afterColumn = array_pop($schema);
			$tableName = $model->UsersLanguage->table;
		} else {
			$tableName = $model->User->table;
			$afterColumn = $userColumn;
			$userColumn = $userAttributeKey;
		}
		$model->Migration->migration['up']['create_field'][$tableName][$userAttributeKey] = array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
			'after' => $afterColumn
		);

		//公開項目フィールド
		$model->Migration->migration['up']['create_field'][$model->User->table][sprintf(self::PUBLIC_FIELD_FORMAT, $userAttributeKey)] = array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'after' => $userColumn
		);
		//ファイルID項目フィールド
		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_IMG) {
			$model->Migration->migration['up']['create_field'][$model->User->table][sprintf(self::FILE_FIELD_FORMAT, $userAttributeKey)] = array(
				'type' => 'integer',
				'null' => true,
				'default' => null,
				'unsigned' => false,
				'after' => printf(self::PUBLIC_FIELD_FORMAT, $userAttributeKey)
			);
		}
		return $model->Migration->run('up');
	}

/**
 * フィールドの削除
 * ※会員項目の削除で呼び出す
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param array $data 登録データ
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function dropColumnByUserAttribute(Model $model, $data) {
		$model->loadModels([
			'User' => 'Users.User',
			'UsersLanguage' => 'Users.UsersLanguage',
		]);

		$model->Migration = new CakeMigration(array('connection' => $model->useDbConfig));
		$userAttributeKey = $data[$model->UserAttributeSetting->alias]['user_attribute_key'];

		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_TEXT ||
				$data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_TEXTAREA) {

			$model->Migration->migration['up']['drop_field'][$model->User->table] = array();
			$tableName = $model->UsersLanguage->table;
		} else {
			$tableName = $model->User->table;
		}

		$model->Migration->migration['up']['drop_field'][$tableName] = array($userAttributeKey);
		$model->Migration->migration['up']['drop_field'][$model->User->table][] =
											sprintf(self::PUBLIC_FIELD_FORMAT, $userAttributeKey);
		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_IMG) {
			$model->Migration->migration['up']['drop_field'][$model->User->table][] =
												sprintf(self::FILE_FIELD_FORMAT, $userAttributeKey);
		}
		return $model->Migration->run('up');
	}

}
