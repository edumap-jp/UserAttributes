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

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.id'); ?>

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.key'); ?>

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.language_id'); ?>

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.row'); ?>

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.col'); ?>

<?php echo $this->Form->hidden($langId . '.' . 'UserAttribute.weight'); ?>

<div class="form-group">
	<?php echo $this->Form->input($langId . '.' . 'UserAttribute.name', array(
			'type' => 'text',
			'label' => __d('user_attributes', 'Item name') . $this->element('NetCommons.required'),
			'class' => 'form-control',
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'UserAttribute',
			'field' => 'name',
		]); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.display_label', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['display_label'],
			//'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.display_label',
			__d('user_attributes', 'Show the item name')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->DataTypeForm->selectDataTypes($langId . '.' . 'UserAttribute.data_type_template_key', array(
			'label' => __d('user_attributes', 'Input type'),
			'class' => 'form-control',
		)); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.required', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['required'],
			//'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.required',
			__d('user_attributes', 'Designate as required items')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.is_system', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['is_system'],
			//'hiddenField' => false
		)); ?>

	<?php echo $this->Form->label(
			$langId . '.' . 'UserAttribute.is_system',
			__d('user_attributes', 'To prohibit the reading and writing of non-members administrator')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox($langId . '.' . 'UserAttribute.self_publicity', array(
			'div' => false,
			'checked' => (bool)$userAttribute['UserAttribute']['self_publicity'],
			//'hiddenField' => false
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
			//'hiddenField' => false
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
