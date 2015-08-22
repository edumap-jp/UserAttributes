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
		'UserAttributes.UserAttributeLayouts',
	);

/**
 * use component
 *
 * @var array
 */
	public $helpers = array(
		'DataTypes.DataTypeForm',
	);

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
			$data = $this->data;
			unset($data['save'], $data['active_lang_id']);

			//登録処理
			$row = $data['UserAttributeSetting']['row'];
			$col = $data['UserAttributeSetting']['col'];
			$data['UserAttributeSetting']['weight'] = $this->UserAttributeSetting->getMaxWeight($row, $col) + 1;

			if ($this->UserAttribute->saveUserAttribute($data)) {
				//正常の場合
				$this->redirect('/user_attributes/user_attributes/index/');
				return;
			}
			$this->handleValidationError($this->UserAttribute->validationErrors);

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
					'id' => null,
					'language_id' => $langId,
					'key' => '',
					'name' => '',
				));
				$this->request->data['UserAttribute'][$index] = $userAttribute['UserAttribute'];
			}

			$this->request->data = Hash::merge($this->request->data,
				$this->UserAttributeSetting->create(array(
					'id' => null,
					'user_attribute_key' => '',
					'data_type_template_key' => 'text',
					'row' => $userAttributeLayout[0]['id'],
					'col' => $userAttributeLayout[0]['col'],
					'required' => false,
					'display' => true,
					'only_administrator' => false,
					'is_systemized' => false,
					'display_label' => true,
					'display_search_list' => false,
					'self_publicity' => false,
					'self_email_reception_possibility' => false,
				))
			);

		}
	}

/**
 * edit
 *
 * @param string $key user_attributes.key
 * @return void
 */
	public function edit($key = null) {
		if ($this->request->isPost()) {
			$data = $this->data;

			//不要パラメータ除去
			unset($data['save'], $data['active_lang_id']);

			//登録処理
			if ($this->UserAttribute->saveUserAttribute($data)) {
				//正常の場合
				$this->redirect('/user_attributes/user_attributes/index/');
				return;
			}
			$this->handleValidationError($this->UserAttribute->validationErrors);

		} else {
			//既存データ取得
			$options = array(
				'recursive' => -1,
				'conditions' => array('key' => $key)
			);
			$userAttribute = $this->UserAttribute->find('all', $options);
			$this->request->data['UserAttribute'] = Hash::extract($userAttribute, '{n}.UserAttribute');

			$data = $this->UserAttributeSetting->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'user_attribute_key' => $key
				),
			));
			$this->request->data = Hash::merge($this->request->data, $data);
		}
	}

/**
 * move
 *
 * @return void
 */
	public function move() {
		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}

		$this->UserAttributeSetting->id = $this->data['UserAttributeSetting']['id'];
		if (! $this->UserAttributeSetting->exists()) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->UserAttributeSetting->saveUserAttributesOrder($this->data)) {
			$this->throwBadRequest();
			return;
		}

		$this->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('type' => 'success'));
		$this->redirect('/user_attributes/user_attributes/index/');
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
