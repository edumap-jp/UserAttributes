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
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Model
 */
class UserAttribute extends UserAttributesAppModel {

/**
 * Field format
 *
 * @var const
 */
	const
		PUBLIC_FIELD_FORMAT = 'is_%s_public',
		FILE_FIELD_FORMAT = '%s_file_id';

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
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				),
			),
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('user_attributes', 'Item name')),
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * 会員項目のレイアウト用のデータ取得
 *
 * @return array 会員項目データ配列
 */
	public function getUserAttributesForLayout() {
		$this->UserRole = ClassRegistry::init('UserRoles.UserRole');

		//UserAttributeデータ取得
		$userAttributes = $this->find('all', $this->findOptionsForLayout());

		//UserAttributeChoiceデータ取得
		$userAttributeIds = Hash::extract($userAttributes, '{n}.UserAttribute.id');
		$userAttributeChoices = $this->UserAttributeChoice->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'user_attribute_id' => $userAttributeIds
			),
		));
		$userAttributeChoices = Hash::combine($userAttributeChoices,
			'{n}.' . $this->UserAttributeChoice->alias . '.id',
			'{n}.' . $this->UserAttributeChoice->alias,
			'{n}.' . $this->UserAttributeChoice->alias . '.user_attribute_id'
		);

		//UserRoleデータの取得
		$userRoles = $this->UserRole->find('all', array(
			'recursive' => -1,
			'fields' => array(
				'id', 'key', 'name'
			),
			'conditions' => array(
				'type' => UserRole::ROLE_TYPE_USER,
				'language_id' => Current::read('Language.id'),
			),
			'order' => 'id'
		));

		//戻り値の設定
		$results = array();
		foreach ($userAttributes as $userAttribute) {
			$userAttributeId = $userAttribute['UserAttribute']['id'];

			$row = $userAttribute['UserAttributeSetting']['row'];
			$col = $userAttribute['UserAttributeSetting']['col'];
			$weight = $userAttribute['UserAttributeSetting']['weight'];
			$results[$row][$col][$weight] = $userAttribute;

			//権限の設定
			if ($userAttribute['UserAttribute']['key'] === 'role_key') {
				$results[$row][$col][$weight]['UserAttributeChoice'] =
						Hash::combine($userRoles, '{n}.UserRole.id', '{n}.UserRole');
			}
			//UserAttributeChoiceにデータがある場合
			if (isset($userAttributeChoices[$userAttributeId])) {
				$results[$row][$col][$weight]['UserAttributeChoice'] = $userAttributeChoices[$userAttributeId];
			}
		}

		return $results;
	}

/**
 * 会員項目の登録
 *
 * @param array $data リクエストデータ
 * @return bool Trueは成功。Falseはバリデーションエラー
 * @throws InternalErrorException
 */
	public function saveUserAttribute($data) {
		$this->loadModels([
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
		]);

		//トランザクションBegin
		$this->begin();

		//バリデーション
		$userAttributeKey = $data['UserAttribute'][0]['key'];
		if (! $this->validateUserAttribute($data)) {
			return false;
		}
		$updated = (bool)$userAttributeKey;

		try {
			//UserAttributeの登録処理
			$userAttributes = array();
			foreach ($data['UserAttribute'] as $i => $userAttribute) {
				$userAttribute['key'] = $userAttributeKey;
				if (! $data['UserAttribute'][$i] = $this->save($userAttribute, false, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
				$userAttributeKey = $data['UserAttribute'][$i]['UserAttribute']['key'];
			}

			//UserAttributeSettingの登録処理
			$data['UserAttributeSetting']['user_attribute_key'] = $userAttributeKey;
			if (! $this->UserAttributeSetting->save($data['UserAttributeSetting'], false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//UserAttributesRoleのデフォルトデータ登録処理
			if (! $updated) {
				$this->saveDefaultUserAttributeRoles($data);
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * UserAttributeのバリデーション処理
 *
 * @param array $data received post data
 * @return bool True on success, false on validation errors
 */
	public function validateUserAttribute($data) {
		foreach ($data['UserAttribute'] as $userAttribute) {
			$this->set($userAttribute);
			if (! $this->validates()) {
				return false;
			}
		}
		$this->UserAttributeSetting->set($data['UserAttributeSetting']);
		if (! $this->UserAttributeSetting->validates()) {
			$this->validationErrors = Hash::merge(
				$this->validationErrors,
				$this->UserAttributeSetting->validationErrors
			);
			return false;
		}

		return true;
	}

/**
 * UserAttribute削除処理
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteUserAttribute($data) {
		$this->loadModels([
			'UserAttributeSetting' => 'UserAttributes.UserAttributeSetting',
		]);

		//トランザクションBegin
		$this->begin();

		$colUserAttributeKey = $this->UserAttributeSetting->alias . '.user_attribute_key';
		$weight = $this->UserAttributeSetting->find('first', array(
			'recursive' => -1,
			'fields' => array('row', 'col', 'weight'),
			'conditions' => array($colUserAttributeKey => $data['key']),
		));

		try {
			//削除項目より後の順番を詰める
			$this->UserAttributeSetting->updateUserAttributeWeight(
				$weight[$this->UserAttributeSetting->alias]['row'],
				$weight[$this->UserAttributeSetting->alias]['col'],
				$weight[$this->UserAttributeSetting->alias]['weight'],
				-1, '>'
			);

			//UserAttributeの削除処理
			if (! $this->deleteAll(array($this->alias . '.key' => $data['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//UserAttributeSettingの削除処理
			if (! $this->UserAttributeSetting->deleteAll(array($colUserAttributeKey => $data['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
