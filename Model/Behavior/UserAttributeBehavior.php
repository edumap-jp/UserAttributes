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
App::uses('UserAttribute', 'UserAttributes.Model');
App::uses('Current', 'NetCommons.Utility');

/**
 * DefaultUserRole Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserRoles\Model\Behavior
 */
class UserAttributeBehavior extends ModelBehavior {

/**
 * CakeMigration object
 *
 * テスト用に定義してあります。
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
	public $cakeMigration = null;

/**
 * Setup
 *
 * @param Model $model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		if ($model->useDbConfig === 'test') {
			$this->cakeMigration = new CakeMigration(array('connection' => $model->useDbConfig));
		} else {
			$this->cakeMigration = new CakeMigration(array('connection' => 'master'));
		}
	}

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

		$pluginsRoles = $model->PluginsRole->cacheFindQuery('all', array(
			'recursive' => -1,
			'fields' => [
				'id', 'role_key', 'plugin_key'
			],
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
				'data_type_key' => $data['UserAttributeSetting']['data_type_key'],
				'only_administrator_readable' =>
								(bool)$data['UserAttributeSetting']['only_administrator_readable'],
				'only_administrator_editable' =>
								(bool)$data['UserAttributeSetting']['only_administrator_editable'],
				'is_system' => (bool)$data['UserAttributeSetting']['is_system']
			);
			$enableUserManager = (bool)Hash::extract(
				$pluginsRoles, '{n}.PluginsRole[role_key=' . $params['role_key'] . ']'
			);

			$userAttributeRole = $model->UserAttributesRole->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'role_key' => $params['role_key'],
					'user_attribute_key' => $params['user_attribute_key'],
				),
			));
			if (! $userAttributeRole) {
				$userAttributeRole = $model->UserAttributesRole->create(array(
					'role_key' => $params['role_key'],
					'user_attribute_key' => $params['user_attribute_key']
				));
			}
			$userAttributeRole = Hash::merge(
				$userAttributeRole,
				$model->UserAttributesRole->defaultUserAttributeRole($params, $enableUserManager)
			);

			$model->UserAttributesRole->create(false);
			if (! $model->UserAttributesRole->save($userAttributeRole, array('validate' => false))) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * 各自でメールの受信可否を設定不可にした場合、User.is_xxxx_mail_receptionをONにする
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param array $before 変更前データ
 * @param array $data 登録データ
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveSelfEmailSetting(Model $model, $before, $data) {
		$model->loadModels([
			'User' => 'Users.User',
		]);

		if (! $before) {
			return true;
		}

		if (Hash::get($before, 'UserAttributeSetting.data_type_key') !== DataType::DATA_TYPE_EMAIL) {
			return true;
		}

		$beforeValue = (int)Hash::get($before, 'UserAttributeSetting.self_email_setting');
		$afterValue = (int)Hash::get($data, 'UserAttributeSetting.self_email_setting');

		$attributeKey = Hash::get($data, 'UserAttributeSetting.user_attribute_key');
		$updateField = sprintf(UserAttribute::MAIL_RECEPTION_FIELD_FORMAT, $attributeKey);
		if ($afterValue === 0 && $beforeValue !== $afterValue) {
			$result = $model->User->updateAll(
				array($model->User->alias . '.' . $updateField => true)
			);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * 会員項目レイアウト用のFindオプション
 *
 * @param Model $model Model ビヘイビア呼び出し元モデル
 * @param array $conditions 条件配列
 * @return array findOptions
 */
	public function findOptionsForLayout(Model $model, $conditions = array()) {
		$model->loadModels([
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
			'UserRoleSetting' => 'UserRoles.UserRoleSetting',
			'UserAttributesRole' => 'UserRoles.UserAttributesRole',
		]);

		$conditions = Hash::merge(
			array($model->alias . '.language_id' => Current::read('Language.id')),
			$conditions
		);

		$options = array(
			'recursive' => -1,
			'fields' => array(
				$model->alias . '.*',
				$model->UserAttributeSetting->alias . '.*',
				$model->UserAttributesRole->alias . '.*',
			),
			'conditions' => $conditions,
			'joins' => array(
				array(
					'table' => $model->UserAttributeSetting->table,
					'alias' => $model->UserAttributeSetting->alias,
					'type' => 'INNER',
					'conditions' => array(
						$model->UserAttributeSetting->alias . '.user_attribute_key' . ' = ' . $model->alias . ' .key',
					),
				),
				array(
					'table' => $model->UserAttributesRole->table,
					'alias' => $model->UserAttributesRole->alias,
					'type' => 'INNER',
					'conditions' => array(
						$model->UserAttributesRole->alias . '.user_attribute_key' . ' = ' . $model->alias . ' .key',
						$model->UserAttributesRole->alias . '.role_key' => Current::read('User.role_key'),
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
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
			'User' => 'Users.User',
			'UsersLanguage' => 'Users.UsersLanguage',
		]);

		$userAttributeKey = $data[$model->UserAttributeSetting->alias]['user_attribute_key'];

		$schema = array_keys($model->User->schema());
		$userColumn = array_pop($schema);

		//会員項目フィールド
		if (Hash::get($data, $model->UserAttributeSetting->alias . '.is_multilingualization')) {
			$schema = array_keys($model->UsersLanguage->schema());
			$afterColumn = array_pop($schema);
			$tableName = $model->UsersLanguage->table;
		} else {
			$tableName = $model->User->table;
			$afterColumn = $userColumn;
			$userColumn = $userAttributeKey;
		}
		$this->cakeMigration->migration['up']['create_field'][$tableName][$userAttributeKey] = array(
			'type' => 'string',
			'null' => true,
			'default' => null,
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
			'after' => $afterColumn
		);

		//公開項目フィールド
		$key = sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey);
		$this->cakeMigration->migration['up']['create_field'][$model->User->table][$key] = array(
			'type' => 'boolean',
			'null' => false,
			'default' => '0',
			'after' => $userColumn
		);
		//メールの受信可否設定項目フィールド
		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_EMAIL) {
			$key = sprintf(UserAttribute::MAIL_RECEPTION_FIELD_FORMAT, $userAttributeKey);
			$this->cakeMigration->migration['up']['create_field'][$model->User->table][$key] = array(
				'type' => 'boolean',
				'null' => false,
				'default' => '1',
				'after' => sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey)
			);
		}
		return $this->cakeMigration->run('up');
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
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
			'User' => 'Users.User',
			'UsersLanguage' => 'Users.UsersLanguage',
		]);

		$userAttributeKey = $data[$model->UserAttributeSetting->alias]['user_attribute_key'];

		if (Hash::get($data, $model->UserAttributeSetting->alias . '.is_multilingualization')) {
			$this->cakeMigration->migration['up']['drop_field'][$model->User->table] = array();
			$tableName = $model->UsersLanguage->table;
		} else {
			$tableName = $model->User->table;
		}

		$this->cakeMigration->migration['up']['drop_field'][$tableName] = array($userAttributeKey);
		$this->cakeMigration->migration['up']['drop_field'][$model->User->table][] =
											sprintf(UserAttribute::PUBLIC_FIELD_FORMAT, $userAttributeKey);
		if ($data[$model->UserAttributeSetting->alias]['data_type_key'] === DataType::DATA_TYPE_EMAIL) {
			$this->cakeMigration->migration['up']['drop_field'][$model->User->table][] =
									sprintf(UserAttribute::MAIL_RECEPTION_FIELD_FORMAT, $userAttributeKey);
		}
		return $this->cakeMigration->run('up');
	}

}
