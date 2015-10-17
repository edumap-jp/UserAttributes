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
class UserAttributeLayoutComponent extends Component {

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::startup
 */
	public function startup(Controller $controller) {
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}
		$this->controller = $controller;

		//Modelの呼び出し
		$this->UserAttributeLayout = ClassRegistry::init('UserAttributes.UserAttributeLayout');
		$this->UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');

		//UserAttributeデータセット
		$userAttributes = $this->UserAttribute->getUserAttributesForLayout();
		$this->controller->set('userAttributes', $userAttributes);

		//UserAttributeLayoutデータセット
		$userAttributeLayouts = $this->UserAttributeLayout->find('all', array(
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$this->controller->set('userAttributeLayouts', $userAttributeLayouts);

		$this->controller->helpers[] = 'UserAttributes.UserAttributeLayout';
	}

}
