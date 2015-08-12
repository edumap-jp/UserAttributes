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

<?php foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) : ?>
	<?php $languageId = $userAttribute['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<?php echo $this->Form->hidden('UserAttribute.' . $index . '.id'); ?>

		<?php echo $this->Form->hidden('UserAttribute.' . $index . '.key'); ?>

		<?php echo $this->Form->hidden('UserAttribute.' . $index . '.language_id'); ?>

		<div class="form-group" ng-show="activeLangId === '<?php echo (string)$languageId; ?>'" ng-cloak>
			<?php echo $this->Form->input('UserAttribute.' . $index . '.' . 'name', array(
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
	<?php endif; ?>
<?php endforeach; ?>

<?php echo $this->Form->hidden('UserAttributeSetting.row'); ?>

<?php echo $this->Form->hidden('UserAttributeSetting.col'); ?>

<?php echo $this->Form->hidden('UserAttributeSetting.weight'); ?>

<?php echo $this->Form->hidden('UserAttributeSetting.display'); ?>

<?php echo $this->Form->hidden('UserAttributeSetting.is_systemized'); ?>

<div class="form-group">
	<?php echo $this->Form->checkbox('UserAttributeSetting.display_label', array(
			'div' => false,
		)); ?>

	<?php echo $this->Form->label(
			'UserAttributeSetting.display_label',
			__d('user_attributes', 'Show the item name')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->DataTypeForm->selectDataTypes('UserAttributeSetting.data_type_template_key', array(
			'label' => __d('user_attributes', 'Input type'),
			'class' => 'form-control',
		)); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox('UserAttributeSetting.required', array(
			'div' => false,
		)); ?>

	<?php echo $this->Form->label(
			'UserAttributeSetting.required',
			__d('user_attributes', 'Designate as required items')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox('UserAttributeSetting.only_administrator', array(
			'div' => false,
		)); ?>

	<?php echo $this->Form->label(
			'UserAttributeSetting.only_administrator',
			__d('user_attributes', 'To prohibit the reading and writing of non-members administrator')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox('UserAttributeSetting.self_publicity', array(
			'div' => false,
		)); ?>

	<?php echo $this->Form->label(
			'UserAttributeSetting.self_publicity',
			__d('user_attributes', 'Enable individual public/private setting')
		); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->checkbox('UserAttributeSetting.self_email_reception_possibility', array(
			'div' => false,
		)); ?>

	<?php echo $this->Form->label(
			'UserAttributeSetting.self_email_reception_possibility',
			__d('user_attributes', 'Enable individual email receipt / non-receipt setting')
		); ?>
</div>

<?php foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) : ?>
	<?php $languageId = $userAttribute['language_id']; ?>

	<?php if (isset($languages[$languageId])) : ?>
		<div class="form-group" ng-show="activeLangId === '<?php echo (string)$languageId; ?>'" ng-cloak>
			<?php echo $this->Form->input('UserAttribute.' . $index . '.description', array(
					'type' => 'textarea',
					'label' => __d('user_attributes', 'Description'),
					'class' => 'form-control',
				)); ?>
		</div>
	<?php endif; ?>
<?php endforeach;
