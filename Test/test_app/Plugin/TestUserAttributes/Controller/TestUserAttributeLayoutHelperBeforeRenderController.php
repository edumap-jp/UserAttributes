<?php
/**
 * UserAttributeLayoutHelperテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * UserAttributeLayoutHelperテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\TestUserAttributes\Controller
 */
class TestUserAttributeLayoutHelperBeforeRenderController extends AppController {

/**
 * 使用ヘルパー
 *
 * @var array
 */
	public $helpers = array(
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

}
