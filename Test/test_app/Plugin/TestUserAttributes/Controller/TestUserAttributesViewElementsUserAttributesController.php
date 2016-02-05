<?php
/**
 * View/Elements/UserAttributes/edit_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/UserAttributes/edit_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttributes\Test\test_app\Plugin\UserAttributes\Controller
 */
class TestUserAttributesViewElementsUserAttributesController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'M17n.SwitchLanguage',
		'DataTypes.DataTypeForm',
	);

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'UserAttributes.UserAttribute',
		'UserAttributes.UserAttributeChoice',
		'UserAttributes.UserAttributeSetting',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeRender() {
		parent::beforeFilter();
		$this->Auth->allow('delete_form', 'choice_edit_form', 'render_index_row', 'render_index_col', 'edit_form');
	}

/**
 * delete_form
 *
 * @return void
 */
	public function delete_form() {
		$this->autoRender = true;
	}

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form() {
		$this->autoRender = true;
	}

/**
 * render_index_row
 *
 * @return void
 */
	public function render_index_row() {
		$this->autoRender = true;
	}

/**
 * render_index_col
 *
 * @return void
 */
	public function render_index_col() {
		$this->autoRender = true;
	}

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form() {
		$this->autoRender = true;

		$this->request->data = array(
			'UserAttributeSetting' => array(
				'id' => '1',
				'row' => '1',
				'col' => '1',
				'weight' => 1,
				'display' => '1',
				'is_system' => '0',
				'user_attribute_key' => 'test2',
				'display_label' => '1',
				'data_type_key' => 'text',
				'is_multilingualization' => '1',
				'required' => '0',
				'only_administrator_readable' => '0',
				'only_administrator_editable' => '0',
				'self_public_setting' => '0',
				'self_email_setting' => '0',
			),
			'UserAttribute' => array(
				0 => array (
					'id' => '1',
					'key' => 'test2',
					'language_id' => '1',
					'name' => 'English name',
					'description' => 'English description',
				),
				1 => array (
					'id' => '2',
					'key' => 'test2',
					'language_id' => '2',
					'name' => 'Japanese name',
					'description' => 'Japanese description',
				),
				//存在しない言語
				2 => array (
					'id' => '3',
					'key' => 'test2',
					'language_id' => '3',
					'name' => 'Other name',
					'description' => 'Other description',
				),
			),
		);
	}

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form_is_system() {
		$this->autoRender = true;
		$this->view = 'edit_form';

		$this->edit_form();
		$this->request->data['UserAttributeSetting']['is_system'] = '1';
	}

/**
 * edit_form
 *
 * @return void
 */
	public function edit_form_action_edit() {
		$this->autoRender = true;
		$this->view = 'edit_form';

		$this->edit_form();
		$this->request->params['action'] = 'edit';
	}

}
