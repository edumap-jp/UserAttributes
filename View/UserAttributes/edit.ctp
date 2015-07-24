<div class="userAttributes form">
<?php echo $this->Form->create('UserAttribute'); ?>
	<fieldset>
		<legend><?php echo __('Edit User Attribute'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('language_id');
		echo $this->Form->input('data_type');
		echo $this->Form->input('plugin_type');
		echo $this->Form->input('label');
		echo $this->Form->input('required');
		echo $this->Form->input('can_read_self');
		echo $this->Form->input('can_edit_self');
		echo $this->Form->input('weight');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UserAttribute.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('UserAttribute.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Attributes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
