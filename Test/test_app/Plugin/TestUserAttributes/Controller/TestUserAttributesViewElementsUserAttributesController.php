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

		$this->request->data = array(
			'UserAttributeChoice' => array(
				'1' => array(
					0 => array (
						'id' => '1',
						'language_id' => '1',
						'user_attribute_id' => '1',
						'key' => 'test_1',
						'name' => 'English name1',
						'code' => 'code1',
						'weight' => 1,
					),
					1 => array (
						'id' => '2',
						'language_id' => '2',
						'user_attribute_id' => '1',
						'key' => 'test_1',
						'name' => 'Japanese name1',
						'code' => 'code1',
						'weight' => 1,
					),
				),
				'2' => array(
					0 => array (
						'id' => '3',
						'language_id' => '1',
						'user_attribute_id' => '2',
						'key' => 'test_2',
						'name' => 'English name2',
						'code' => 'code2',
						'weight' => 2,
					),
					1 => array (
						'id' => '4',
						'language_id' => '2',
						'user_attribute_id' => '2',
						'key' => 'test_2',
						'name' => 'Japanese name1',
						'code' => 'code2',
						'weight' => 2,
					),
				),
			),
		);
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

		App::uses('UserAttributeFixture', 'UserAttributes.Test/Fixture');
		App::uses('UserAttributeSettingFixture', 'UserAttributes.Test/Fixture');

		$ruserAttributeRecords = (new UserAttributeFixture())->records;
		//存在しない言語
		array_push($ruserAttributeRecords, array(
			'id' => '3',
			'key' => 'user_attribute_key',
			'language_id' => '3',
			'name' => 'Other name',
			'description' => 'Other description',
		));
		$this->request->data = array(
			'UserAttributeSetting' => (new UserAttributeSettingFixture())->records[0],
			'UserAttribute' => $ruserAttributeRecords,
		);
		debug($this->request->data);
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
