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
		'name' => 'UserAttributeDidplayForm' . $userAttribute['UserAttribute']['id'],
		'url' => array(
			'plugin' => 'user_attributes',
			'controller' => 'user_attributes',
			'action' => 'display',
			$userAttribute['UserAttribute']['id']
		),
	)); ?>

<?php echo $this->Form->hidden('UserAttribute.id', array(
		'value' => $userAttribute['UserAttribute']['id'],
	)); ?>

<button class="btn btn-xs btn-default<?php echo ($userAttribute['UserAttribute']['display'] ? ' active' : ''); ?>" type="button">
	<?php if ($userAttribute['UserAttribute']['display']) : ?>
		<span class="glyphicon glyphicon-eye-open"> </span>
	<?php else : ?>
		<span class="glyphicon glyphicon-eye-close"> </span>
	<?php endif; ?>
</button>

<?php echo $this->Form->end();
