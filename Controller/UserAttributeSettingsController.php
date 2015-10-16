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
 * UserAttributeSettingsController
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Controller
 */
class UserAttributeSettingsController extends UserAttributesAppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'UserAttributes.UserAttributeSetting',
	);

/**
 * edit
 *
 * @return void
 */
	public function display() {
		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}

		$this->UserAttributeSetting->id = $this->data['UserAttributeSetting']['id'];
		if (! $this->UserAttributeSetting->exists()) {
			$this->throwBadRequest();
			return;
		}

		if (! $this->UserAttributeSetting->saveUserAttributeSetting($this->data)) {
			$this->throwBadRequest();
			return;
		}

		$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('class' => 'success'));
		$this->redirect('/user_attributes/user_attributes/index/');
	}
}
