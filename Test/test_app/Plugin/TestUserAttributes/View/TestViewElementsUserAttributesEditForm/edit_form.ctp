<?php
/**
 * View/Elements/UserAttributes/edit_formテスト用Viewファイル
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('UserAttribute', 'UserAttributes.Model');
class_exists('UserAttribute');
?>

View/Elements/UserAttributes/edit_form

<?php echo $this->NetCommonsForm->create('UserAttribute'); ?>
<?php echo $this->element('UserAttributes.UserAttributes/edit_form'); ?>
<?php echo $this->NetCommonsForm->end();
