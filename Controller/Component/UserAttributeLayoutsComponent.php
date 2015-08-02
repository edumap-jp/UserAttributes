<?php
/**
 * UserAttributeLayouts Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * UserAttributeLayouts Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Controller
 */
class UserAttributeLayoutsComponent extends Component {

/**
 * startup
 *
 * @param Controller $controller Controller
 * @return void
 */
	public function startup(Controller $controller) {
		$this->controller = $controller;

		//RequestActionの場合、スキップする
		if (! empty($this->controller->request->params['requested'])) {
			return;
		}

		$userAttributes = $this->controller->UserAttribute->getUserAttributesForLayout(Configure::read('Config.languageId'));
		$this->controller->set('userAttributes', $userAttributes);

		$userAttributeLayouts = $this->controller->UserAttributeLayout->find('all', array(
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$this->controller->set('userAttributeLayouts', $userAttributeLayouts);
	}

}
