<div class="userAttributes view">
<h2><?php echo __('User Attribute'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Language Id'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['language_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Data Type'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['data_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Plugin Type'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['plugin_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Required'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['required']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Can Read Self'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['can_read_self']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Can Edit Self'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['can_edit_self']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Creator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userAttribute['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $userAttribute['TrackableCreator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trackable Updater'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userAttribute['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $userAttribute['TrackableUpdater']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($userAttribute['UserAttribute']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Attribute'), array('action' => 'edit', $userAttribute['UserAttribute']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Attribute'), array('action' => 'delete', $userAttribute['UserAttribute']['id']), null, __('Are you sure you want to delete # %s?', $userAttribute['UserAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Attributes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Attribute'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
