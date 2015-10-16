<?php
/**
 * UserAttributeLayout Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributesAppModel', 'UserAttributes.Model');

/**
 * UserAttributeLayout Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Model
 */
class UserAttributeLayout extends UserAttributesAppModel {

/**
 * レイアウト列数
 */
	const LAYOUT_COL_NUMBER = 2;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
 * レイアウトの保存
 *
 * @param array $data リクエストデータ
 * @param string $fieldName フィールド名
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveUserAttributeLayout($data, $fieldName) {
		//トランザクションBegin
		$this->begin();

		$this->id = $data[$this->alias]['id'];
		if (! $this->exists()) {
			return false;
		}

		try {
			//UserAttributeLayoutテーブルの登録
			if (! $this->saveField($fieldName, $data[$this->alias][$fieldName])) {
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
