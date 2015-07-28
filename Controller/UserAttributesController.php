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
		'UserAttributes.UserAttribute',
		'UserAttributes.UserAttributeLayout',
		'M17n.Language'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'ControlPanel.ControlPanelLayout'
	);

/**
 * use component
 *
 * @var array
 */
	public $helpers = array(
		'DataTypes.DataTypeForm' => array(
			'plugin' => 'users'
		)
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$userAttributes = $this->UserAttribute->getUserAttributesForLayout(Configure::read('Config.languageId'));
		$this->set('userAttributes', $userAttributes);

		$userAttributeLayouts = $this->UserAttributeLayout->find('all', array(
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$this->set('userAttributeLayouts', $userAttributeLayouts);
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
	}

/**
 * add
 *
 * @return void
 */
	public function add($row = null) {
		$this->view = 'edit';

		if (! $userAttributeLayout = $this->UserAttributeLayout->findById($row)) {
			$this->throwBadRequest();
			return;
		}

		//言語データ取得
		$languages = $this->Language->find('list', array(
			'fields' => array('Language.id', 'Language.code')
		));
		$this->set('languages', $languages);

		if ($this->request->isPut()) {

		} else {
			foreach ($languages as $langId => $langCode) {
				$this->request->data[$langId] = $this->UserAttribute->create(array(
					'id' => null,
					'language_id' => $langId,
					'name' => '',
					'data_type_template_key' => 'text',
					'row' => $userAttributeLayout['UserAttributeLayout']['id'],
					'col' => $userAttributeLayout['UserAttributeLayout']['col'],
					'required' => true,
					'is_system' => false,
					'display_label' => true,
					'display_search_list' => false,
					'self_publicity' => false,
					'self_email_reception_possibility' => false,
				));
			}
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit($key = null) {
		//言語データ取得
		$languages = $this->Language->find('list', array(
			'fields' => array('Language.id', 'Language.code')
		));
		$this->set('languages', $languages);

		$options = array(
			'recursive' => -1,
			'conditions' => array('key' => $key)
		);
		$userAttributes = $this->UserAttribute->find('all', $options);

		$defaultUserAttribute = Hash::extract($userAttributes, '{n}.UserAttribute[language_id=' . Configure::read('Config.langId') . ']');
		if (! $defaultUserAttribute) {
			$this->throwBadRequest();
			return;
		}

		foreach ($languages as $langId => $langCode) {
			$userAttribute = Hash::extract($userAttributes, '{n}.UserAttribute[language_id=' . $langId . ']');
			if (! $userAttribute) {
				$this->request->data[$langId]['UserAttribute'] = $defaultUserAttribute[0];
				$this->request->data[$langId]['UserAttribute']['id'] = null;
				$this->request->data[$langId]['UserAttribute']['language_id'] = $langId;
			} else {
				$this->request->data[$langId]['UserAttribute'] = $userAttribute[0];
			}
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

		$this->UserAttribute->id = $this->data['UserAttribute']['id'];
		if (! $this->UserAttribute->exists()) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->UserAttribute->saveUserAttributesOrder($this->data)) {
			$this->throwBadRequest();
			return;
		}

		$this->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('class' => 'success'));
		$this->redirect('/user_attributes/user_attributes/index/');
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
	}
}