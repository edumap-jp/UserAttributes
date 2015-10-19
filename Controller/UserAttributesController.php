<?php
/**
 * UserAttributes Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('UserAttributesAppController', 'UserAttributes.Controller');

/**
 * UserAttributes Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Controller
 */
class UserAttributesController extends UserAttributesAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'M17n.Language',
		'UserAttributes.UserAttribute',
		'UserAttributes.UserAttributeSetting',
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout',
		'M17n.SwitchLanguage',
		'UserAttributes.UserAttributeLayout',
		'DataTypes.DataTypeForm',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		if ($this->params['action'] === 'add') {
		} else {
			$this->DataTypeForm->dataTypes = $this->UserAttributeSetting->dataTypes;
		}
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
	}

/**
 * add
 *
 * @param int $row Add row number
 * @return void
 */
	public function add($row = null) {
		$this->view = 'edit';

		if ($this->request->isPost()) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			$row = $this->request->data['UserAttributeSetting']['row'];
			$col = $this->request->data['UserAttributeSetting']['col'];
			$this->request->data['UserAttributeSetting']['weight'] = $this->UserAttributeSetting->getMaxWeight($row, $col) + 1;

			if ($this->UserAttribute->saveUserAttribute($this->request->data)) {
				//正常の場合
				$this->redirect('/user_attributes/user_attributes/index/');
				return;
			}
			$this->NetCommons->handleValidationError($this->UserAttribute->validationErrors);

		} else {
			//レイアウトデータ取得
			if (! $userAttributeLayout = Hash::extract(
					$this->viewVars['userAttributeLayouts'],
					'{n}.UserAttributeLayout[id=' . $row . ']'
			)) {
				$this->throwBadRequest();
				return;
			}

			//初期値セット
			$this->request->data['UserAttribute'] = array();
			foreach (array_keys($this->viewVars['languages']) as $langId) {
				$index = count($this->request->data['UserAttribute']);
				$userAttribute = $this->UserAttribute->create(array(
					'language_id' => $langId,
				));
				$this->request->data['UserAttribute'][$index] = $userAttribute['UserAttribute'];
			}

			$this->request->data = Hash::merge($this->request->data,
				$this->UserAttributeSetting->create(array(
					'data_type_key' => 'text',
					'row' => $userAttributeLayout[0]['id'],
					'col' => $userAttributeLayout[0]['col'],
				))
			);
		}

		$this->DataTypeForm->dataTypes = $this->UserAttributeSetting->addDataTypes;
	}

/**
 * edit
 *
 * @param string $key user_attributes.key
 * @return void
 */
	public function edit($key = null) {
		if ($this->request->isPost()) {
			//不要パラメータ除去
			unset($this->request->data['save'], $this->request->data['active_lang_id']);

			//登録処理
			if ($this->UserAttribute->saveUserAttribute($this->request->data)) {
				//正常の場合
				$this->redirect('/user_attributes/user_attributes/index/');
				return;
			}
			$this->NetCommons->handleValidationError($this->UserAttribute->validationErrors);

		} else {
			//既存データ取得
			$options = array(
				'recursive' => -1,
				'conditions' => array('key' => $key)
			);
			$userAttribute = $this->UserAttribute->find('all', $options);
			if (! $userAttribute) {
				$this->throwBadRequest();
				return;
			}
			$this->request->data['UserAttribute'] = Hash::extract($userAttribute, '{n}.UserAttribute');

			$data = $this->UserAttributeSetting->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'user_attribute_key' => $key
				),
			));
			$this->request->data = Hash::merge($this->request->data, $data);
		}

		if ($this->request->data['UserAttributeSetting']['is_systemized']) {
			$this->DataTypeForm->dataTypes = $this->UserAttributeSetting->editDataTypes;
		} else {
			$this->DataTypeForm->dataTypes = $this->UserAttributeSetting->addDataTypes;
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->isDelete()) {
			$this->throwBadRequest();
			return;
		}

		$this->UserAttribute->deleteUserAttribute($this->data['UserAttribute'][0]);
		$this->redirect('/user_attributes/user_attributes/index/');
	}

}
