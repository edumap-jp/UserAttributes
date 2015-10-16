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

<?php echo $this->NetCommonsForm->create(null, array(
		'novalidate' => true,
		'name' => 'UserAttributeDidplayForm' . $userAttribute['UserAttributeSetting']['id'],
		'url' => $this->NetCommonsHtml->url(array(
			'controller' => 'user_attribute_settings',
			'action' => 'display',
			$userAttribute['UserAttributeSetting']['id']
		)),
	)); ?>

<?php echo $this->NetCommonsForm->hidden('UserAttributeSetting.id', array(
		'value' => $userAttribute['UserAttributeSetting']['id'],
	)); ?>

<?php
	if ($userAttribute['UserAttributeSetting']['display']) {
		echo $this->NetCommonsForm->hidden('UserAttributeSetting.display', array('value' => false));
		$buttonIcon = 'glyphicon-eye-open';
	} else {
		echo $this->NetCommonsForm->hidden('UserAttributeSetting.display', array('value' => true));
		$buttonIcon = 'glyphicon-eye-close';
	}
?>

<?php echo $this->Button->save('<span class="glyphicon ' . $buttonIcon . '"> </span>', array(
	'class' => 'btn btn-xs btn-default' . ($userAttribute['UserAttributeSetting']['display'] ? ' active' : '')
)); ?>

<?php echo $this->NetCommonsForm->end();
