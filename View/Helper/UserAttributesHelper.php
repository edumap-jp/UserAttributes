<?php
/**
 * UserAttributesLayoutHelper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * ControlPanelLayoutHelper
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\ControlPanel\Controller
 */
class UserAttributesHelper extends AppHelper {

/**
 * Has system
 *
 * @var array
 */
	public $hasSystem = false;

/**
 * UserAttributes data
 *
 * @var array
 */
	public $userAttributes;

/**
 * UserAttributeLayouts data
 *
 * @var array
 */
	public $userAttributeLayouts;

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		if (isset($settings['hasSystem'])) {
			$this->hasSystem = $settings['hasSystem'];
		}

		//Modelの読み込み
		$UserAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
		$UserAttributeLayout = ClassRegistry::init('UserAttributes.UserAttributeLayout');


	}
}
