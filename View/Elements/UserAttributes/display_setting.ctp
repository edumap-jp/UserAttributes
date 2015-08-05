<?php
/**
 * Move UserAttribute element
 *   - $userAttribute: userAttribute
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create(null, array(
		'novalidate' => true,
		'name' => 'UserAttributeDidplayForm' . $userAttribute['UserAttributeSetting']['id'],
		'url' => array(
			'plugin' => 'user_attributes',
			'controller' => 'user_attributes',
			'action' => 'display',
			$userAttribute['UserAttributeSetting']['id']
		),
	)); ?>

<?php echo $this->Form->hidden('UserAttributeSetting.id', array(
		'value' => $userAttribute['UserAttributeSetting']['id'],
	)); ?>

<button class="btn btn-xs btn-default<?php echo ($userAttribute['UserAttributeSetting']['display'] ? ' active' : ''); ?>" type="button">
	<?php if ($userAttribute['UserAttributeSetting']['display']) : ?>
		<span class="glyphicon glyphicon-eye-open"> </span>
	<?php else : ?>
		<span class="glyphicon glyphicon-eye-close"> </span>
	<?php endif; ?>
</button>

<?php echo $this->Form->end();