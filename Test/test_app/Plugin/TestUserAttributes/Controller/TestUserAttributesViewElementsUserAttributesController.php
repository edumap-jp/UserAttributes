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

		App::uses('UserAttributeChoice4testFixture', 'UserAttributes.Test/Fixture');
		$userAttributeChoiceRecords = (new UserAttributeChoice4testFixture())->records;
		$userAttributeChoices = Hash::extract($userAttributeChoiceRecords, '{n}[user_attribute_id=8]');
		$userAttributeChoices = array_merge($userAttributeChoices, Hash::extract($userAttributeChoiceRecords, '{n}[user_attribute_id=28]'));
		$userAttributeChoices = Hash::combine($userAttributeChoices, '{n}.id', '{n}', '{n}.user_attribute_id');

		$this->request->data = array(
			'UserAttributeChoice' => $userAttributeChoices,
		);
	}

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form_null() {
		$this->autoRender = true;
		$this->view = 'choice_edit_form';

		$this->request->data = array(
			'UserAttributeChoice' => null,
		);
	}

/**
 * choice_edit_form
 *
 * @return void
 */
	public function choice_edit_form_without_id() {
		$this->autoRender = true;
		$this->view = 'choice_edit_form';

		$this->choice_edit_form();
		$this->request->data['UserAttributeChoice']['8']['2']['id'] = 0;
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

		$userAttributeRecords = (new UserAttributeFixture())->records;
		//存在しない言語
		array_push($userAttributeRecords, array(
			'id' => '3',
			'key' => 'user_attribute_key',
			'language_id' => '3',
			'name' => 'Other name',
			'description' => 'Other description',
		));
		$this->request->data = array(
			'UserAttributeSetting' => (new UserAttributeSettingFixture())->records[0],
			'UserAttribute' => $userAttributeRecords,
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
