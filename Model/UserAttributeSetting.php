<?php
/**
 * UserAttributeSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributesAppModel', 'UserAttributes.Model');

/**
 * UserAttributeSetting Model
 */
class UserAttributeSetting extends UserAttributesAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_attribute_key' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'data_type_template_key' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
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

/**
 * getMaxWeight
 *
 * @param int $row Row number
 * @param int $col Col number
 * @return int $weight user_attribute_settings.weight
 */
	public function getMaxWeight($row, $col) {
		$order = $this->find('first', array(
			'recursive' => -1,
			'fields' => array('weight'),
			'conditions' => array('row' => $row, 'col' => $col),
			'order' => array('weight' => 'DESC')
		));

		if (isset($order['UserAttributeSetting']['weight'])) {
			$weight = (int)$order['UserAttributeSetting']['weight'];
		} else {
			$weight = 0;
		}
		return $weight;
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
		$this->begin();

		try {
			////バリデーション
			//$indexes = array_keys($data['LinkOrders']);
			//foreach ($indexes as $i) {
			//	if (! $this->validateLinkOrder($data['LinkOrders'][$i])) {
			//		return false;
			//	}
			//}
			//
			////登録処理
			//foreach ($indexes as $i) {
			//	if (! $this->save($data['LinkOrders'][$i], false, false)) {
			//		throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			//	}
			//}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

/**
 * 表示・非表示の切り替え
 *
 * @param array $data リクエストデータ
 * @param string $fieldName フィールド名
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveUserAttributeSetting($data, $fieldName) {
		//トランザクションBegin
		$this->begin();

		$this->id = $data[$this->alias]['id'];
		if (! $this->exists()) {
			return false;
		}

		try {
			//UserAttributeSettingテーブルの登録
			if (! $this->saveField($fieldName, $data[$this->alias][$fieldName], false)) {
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
