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

App::uses('UsersAppModel', 'Users.Model');

/**
 * UserAttribute Model
 */
class UserAttribute extends UsersAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
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
	//		'className' => 'Role',
	//		'joinTable' => 'roles_user_attributes',
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
			'data_type_template_key' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item name')),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'row' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'col' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
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
 * getMaxWeight
 *
 * @param int $row Row number
 * @param int $col Col number
 * @return int $weight user_attributes.weight
 */
	public function getMaxWeight($row, $col) {
		$order = $this->find('first', array(
				'recursive' => -1,
				'fields' => array('weight'),
				'conditions' => array('row' => $row, 'col' => $col),
				'order' => array('weight' => 'DESC')
			));

		if (isset($order[$this->alias]['weight'])) {
			$weight = (int)$order[$this->alias]['weight'];
		} else {
			$weight = 0;
		}
		return $weight;
	}

/**
 * Get UserAttributes data for layout
 *
 * @param int $langId languages.id
 * @return mixed array UserAttributes data
 */
	public function getUserAttributesForLayout($langId) {
		$ret = $this->find('all', array(
			'recursive' => -1,
			'conditions' => array('language_id' => (int)$langId),
			'order' => array('row' => 'asc', 'col' => 'asc', 'weight' => 'asc')
		));

		$userAttributes = array();
		foreach ($ret as $userAttribute) {
			$userAttributes[$userAttribute['UserAttribute']['row']][$userAttribute['UserAttribute']['col']][$userAttribute['UserAttribute']['weight']] = $userAttribute;
		}

		return $userAttributes;
	}

/**
 * Save UserAttributes
 *
 * @param array $data received post data
 * @param bool $created True is created, false is updated
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveUserAttribute($data) {
		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		//バリデーション
		foreach ($data as $userAttribute) {
			if (! $this->validateUserAttribute($userAttribute)) {
				return false;
			}
		}

		try {
			//登録処理
			foreach ($data as $userAttribute) {
				if (! $this->save($userAttribute, false, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

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
 * Move Order UserAttributes
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 * @throws InternalErrorException
 */
	public function saveUserAttributesOrder($data) {
		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
//			//バリデーション
//			$indexes = array_keys($data['LinkOrders']);
//			foreach ($indexes as $i) {
//				if (! $this->validateLinkOrder($data['LinkOrders'][$i])) {
//					return false;
//				}
//			}
//
//			//登録処理
//			foreach ($indexes as $i) {
//				if (! $this->save($data['LinkOrders'][$i], false, false)) {
//					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//				}
//			}

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
 * @param array $contains Optional validate sets
 * @return bool True on success, false on validation errors
 */
	public function validateUserAttribute($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		if (in_array('UserAttributeChoices', $contains, true)) {
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
			'UserAttributes' => 'UserAttributes.UserAttribute',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//後で追加、、DELETEする前に順番の変更

			//削除処理
			if (! $this->deleteAll(array($this->alias . '.key' => $data['UserAttribute']['key']), false)) {
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
