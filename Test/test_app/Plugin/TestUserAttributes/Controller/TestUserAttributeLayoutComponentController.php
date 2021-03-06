<?php
/**
 * UserAttributeLayoutComponentテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * UserAttributeLayoutComponentテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestUserAttributeLayoutComponentController extends AppController {

/**
 * 使用コンポーネント
 *
 * @var array
 */
	public $components = array(
		'UserAttributes.UserAttributeLayout'
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
	}

/**
 * index
 *
 * @return void
 */
	public function index_request_action() {
		$this->autoRender = true;
		$view = $this->requestAction('/' . $this->params['plugin'] . '/' . $this->params['controller'] . '/index', array('return'));
		$this->set('view', $view);
	}

}
