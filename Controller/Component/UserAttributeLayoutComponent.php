<?php
/**
 * 会員項目のレイアウト Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * 会員項目のレイアウト Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Controller
 */
class UserAttributeLayoutComponent extends Component {

/**
 * 会員項目のレイアウトに必要なデータを取得し、viewにセットする
 *
 * @param Controller $controller コントローラ
 * @return void
 * @link http://book.cakephp.org/2.0/ja/controllers/components.html#Component::startup Component::startup
 */
	public function startup(Controller $controller) {
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}

		//Modelの呼び出し
		$controller->UserAttributeLayout = ClassRegistry::init('UserAttributes.UserAttributeLayout');
		$controller->UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');

		//UserAttributeデータセット
		$userAttributes = $controller->UserAttribute->getUserAttributesForLayout();
		$controller->set('userAttributes', $userAttributes);

		//UserAttributeLayoutデータセット
		$userAttributeLayouts = $controller->UserAttributeLayout->find('all', array(
			'fields' => array('id', 'col'),
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$controller->set('userAttributeLayouts', $userAttributeLayouts);
	}

}
