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
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'key' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
				//'message' => 'Your custom message here',
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
	);

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
	//public $hasMany = array(
	//	'UserAttributeChoice' => array(
	//		'className' => 'UserAttributes.UserAttributeChoice',
	//		'foreignKey' => 'user_attribute_id',
	//		'dependent' => false,
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'exclusive' => '',
	//		'finderQuery' => '',
	//		'counterQuery' => ''
	//	)
	//);


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

}
