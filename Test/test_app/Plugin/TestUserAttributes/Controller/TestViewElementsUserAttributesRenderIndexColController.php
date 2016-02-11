<?php
/**
 * View/Elements/UserAttributes/render_index_colテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');
App::uses('UserAttributeLayoutFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttributeSetting4editFixture', 'UserAttributes.Test/Fixture');
App::uses('UserAttribute4editFixture', 'UserAttributes.Test/Fixture');

/**
 * View/Elements/UserAttributes/render_index_colテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestViewElementsUserAttributesRenderIndexColController extends AppController {

/**
 * use model
 *
 * @var array
 */
	public $uses = false;

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'UserAttributes.UserAttribute',
		'UserAttributes.UserAttributeLayout',
	);

/**
 * render_index_col
 *
 * @return void
 */
	public function render_index_col() {
		$this->autoRender = true;
		$this->view = 'render_index_col';

		//テストデータ生成
		Current::$current['User']['role_key'] = UserRole::USER_ROLE_KEY_SYSTEM_ADMINISTRATOR;

		$UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
		UserAttribute::$userAttributes = null;
		$userAttributes = $UserAttribute->getUserAttributesForLayout();
		$this->set('userAttributes', $userAttributes);

		$UserAttributeLayout = ClassRegistry::init('UserAttributes.UserAttributeLayout');
		$userAttributeLayouts = $UserAttributeLayout->find('all', array(
			'fields' => array('id', 'col'),
			'recursive' => -1,
			'order' => array('id' => 'asc'),
		));
		$this->set('userAttributeLayouts', $userAttributeLayouts);

		Current::$current['User']['role_key'] = null;

		$this->set('data', array(
			'layout' => array('UserAttributeLayout' => (new UserAttributeLayoutFixture())->records[0]),
			'userAttribute' => array(
				'UserAttributeSetting' => (new UserAttributeSetting4editFixture())->records[0],
				'UserAttribute' => (new UserAttribute4editFixture())->records[1],
			),
		));
	}

/**
 * render_index_col(display=false用のテスト)
 *
 * @return void
 */
	public function render_index_col_display_false() {
		$this->render_index_col();

		$this->set('data', array(
			'layout' => array('UserAttributeLayout' => (new UserAttributeLayoutFixture())->records[0]),
			'userAttribute' => array(
				'UserAttributeSetting' => (new UserAttributeSetting4editFixture())->records[2],
				'UserAttribute' => (new UserAttribute4editFixture())->records[5],
			),
		));
	}

}
