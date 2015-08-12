<?php
/**
 * UserAttribute Model
 *
 * @property Language $Language
 * @property UserAttributeChoice $UserAttributeChoice
 * @property Role $Role
 * @property User $User
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributesAppModel', 'UserAttributes.Model');

/**
 * UserAttribute Model
 */
class UserAttribute extends UserAttributesAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'UserAttributes.UserAttribute'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Language' => array(
			'className' => 'M17n.Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserAttributeSetting' => array(
			'className' => 'UserAttributes.UserAttributeSetting',
			'foreignKey' => false,
			'conditions' => 'UserAttribute.key = UserAttributeSetting.user_attribute_key',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserAttributeChoice' => array(
			'className' => 'UserAttributes.UserAttributeChoice',
			'foreignKey' => 'user_attribute_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	//public $hasAndBelongsToMany = array(
	//	'Role' => array(
	//		'className' => 'RolesRole',
	//		'joinTable' => 'user_attributes_roles',
	//		'foreignKey' => 'user_attribute_id',
	//		'associationForeignKey' => 'role_id',
	//		'unique' => 'keepExisting',
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'finderQuery' => '',
	//	),
	//	'User' => array(
	//		'className' => 'User',
	//		'joinTable' => 'user_attributes_users',
	//		'foreignKey' => 'user_attribute_id',
	//		'associationForeignKey' => 'user_id',
	//		'unique' => 'keepExisting',
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'finderQuery' => '',
	//	)
	//);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'language_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item name')),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get UserAttributes data for layout
 *
 * @param int $langId languages.id
 * @return mixed array UserAttributes data
 */
	public function getUserAttributesForLayout($langId) {
		$ret = $this->find('all', array(
			'recursive' => 0,
			'conditions' => array(
				'UserAttribute.language_id' => (int)$langId
			),
			'order' => array(
				'UserAttributeSetting.row' => 'asc',
				'UserAttributeSetting.col' => 'asc',
				'UserAttributeSetting.weight' => 'asc'
			)
		));

		$userAttributes = array();
		foreach ($ret as $userAttribute) {
			$row = $userAttribute['UserAttributeSetting']['row'];
			$col = $userAttribute['UserAttributeSetting']['col'];
			$weight = $userAttribute['UserAttributeSetting']['weight'];
			$userAttributes[$row][$col][$weight] = $userAttribute;
		}
		return $userAttributes;
	}

/**
 * Save UserAttributes
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveUserAttribute($data) {
		$this->loadModels([
			'UserAttribute' => 'UserAttributes.UserAttribute',
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		//バリデーション
		$userAttributeKey = $data['UserAttribute'][0]['key'];
		foreach ($data['UserAttribute'] as $userAttribute) {
			if (! $this->validateUserAttribute($userAttribute)) {
				return false;
			}
		}
		if (! $this->UserAttributeSetting->validateUserAttributeSetting($data['UserAttributeSetting'])) {
			$this->validationErrors = Hash::merge($this->validationErrors, $this->UserAttributeSetting->validationErrors);
			return false;
		}

		try {
			//登録処理
			$userAttributes = array();
			foreach ($data['UserAttribute'] as $i => $userAttribute) {
				$userAttribute['key'] = $userAttributeKey;
				if (! $userAttributes[$i] = $this->save($userAttribute, false, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				$userAttributeKey = $userAttributes[$i]['UserAttribute']['key'];
			}

			$data['UserAttributeSetting']['user_attribute_key'] = $userAttributeKey;
			if (! $this->UserAttributeSetting->save($data['UserAttributeSetting'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//UserAttributesRoleのデフォルトデータ登録処理
			$this->saveDefaultUserAttributeRoles($data);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate of UserAttribute
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateUserAttribute($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}

/**
 * Delete UserAttribute
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteUserAttribute($data) {
		$this->loadModels([
			'UserAttribute' => 'UserAttributes.UserAttribute',
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//後で追加、、DELETEする前に順番の変更

			//削除処理
			if (! $this->deleteAll(array($this->alias . '.key' => $data['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$userAttributeKey = $this->UserAttributeSetting->alias . '.user_attribute_key';
			if (! $this->UserAttributeSetting->deleteAll(array($userAttributeKey => $data['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
