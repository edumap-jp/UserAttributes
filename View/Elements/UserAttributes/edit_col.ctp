<?php
/**
 * UserAttributeLayout element
 *   - $layout: layout
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
		'url' => array(
			'plugin' => 'user_attributes',
			'controller' => 'user_attribute_layouts',
			'action' => 'edit',
			$layout['UserAttributeLayout']['id']
		),
	)); ?>

<?php echo $this->Form->hidden('UserAttributeLayout.id', array(
		'value' => $layout['UserAttributeLayout']['id'],
	)); ?>

<?php
	$options = array(
		'1' => __d('user_attributes', '%s Col', 1),
		'2' => __d('user_attributes', '%s Cols', 2),
	);
	echo $this->Form->select('UserAttributeLayout.col', $options, array(
			'value' => $layout['UserAttributeLayout']['col'],
			'class' => 'form-control',
			'empty' => false,
			'onchange' => 'submit()'
		));
?>

<?php echo $this->Form->end();
