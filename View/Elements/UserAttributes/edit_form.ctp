<?php
/**
 * UserAttribute edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="form-group">
	<?php echo $this->Form->input($langId . '.' . 'UserAttribute.name', array(
			'type' => 'text',
			'label' => __d('user_attributes', 'Item name') . $this->element('NetCommons.required'),
			'class' => 'form-control',
		)); ?>
</div>

<div class="form-group">
	<?php echo $this->DataTypeForm->selectDataTypes($langId . '.' . 'UserAttribute.data_type_template_key', array(
			'label' => __d('user_attributes', 'Input type'),
			'class' => 'form-control',
		)); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.is_system', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['is_system'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.is_system',
			__d('user_attributes', 'System items')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.required', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['required'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.required',
			__d('user_attributes', 'Designate as required items')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.display_label', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['display_label'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.display_label',
			__d('user_attributes', 'Show the item name')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.display_search_list', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['display_search_list'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.display_search_list',
			__d('user_attributes', 'Show on the search results')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.self_publicity', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['self_publicity'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.self_publicity',
			__d('user_attributes', 'Enable individual public/private setting')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.self_email_reception_possibility', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['self_email_reception_possibility'],
			'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.self_email_reception_possibility',
			__d('user_attributes', 'Enable individual email receipt / non-receipt setting')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->input($langId . '.' . 'UserAttribute.description', array(
			'type' => 'textarea',
			'label' => __d('user_attributes', 'Description'),
			'class' => 'form-control',
		)); ?>
</div>
