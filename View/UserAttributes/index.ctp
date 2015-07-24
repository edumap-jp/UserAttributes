<div class="userAttributes index">
	<h2><?php echo __('User Attributes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('language_id'); ?></th>
			<th><?php echo $this->Paginator->sort('data_type'); ?></th>
			<th><?php echo $this->Paginator->sort('plugin_type'); ?></th>
			<th><?php echo $this->Paginator->sort('label'); ?></th>
			<th><?php echo $this->Paginator->sort('required'); ?></th>
			<th><?php echo $this->Paginator->sort('can_read_self'); ?></th>
			<th><?php echo $this->Paginator->sort('can_edit_self'); ?></th>
			<th><?php echo $this->Paginator->sort('weight'); ?></th>
			<th><?php echo $this->Paginator->sort('created_user'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified_user'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($userAttributes as $userAttribute): ?>
	<tr>
		<td><?php echo h($userAttribute['UserAttribute']['id']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['language_id']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['data_type']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['plugin_type']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['label']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['required']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['can_read_self']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['can_edit_self']); ?>&nbsp;</td>
		<td><?php echo h($userAttribute['UserAttribute']['weight']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userAttribute['TrackableCreator']['id'], array('controller' => 'users', 'action' => 'view', $userAttribute['TrackableCreator']['id'])); ?>
		</td>
		<td><?php echo h($userAttribute['UserAttribute']['created']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userAttribute['TrackableUpdater']['id'], array('controller' => 'users', 'action' => 'view', $userAttribute['TrackableUpdater']['id'])); ?>
		</td>
		<td><?php echo h($userAttribute['UserAttribute']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userAttribute['UserAttribute']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userAttribute['UserAttribute']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userAttribute['UserAttribute']['id']), null, __('Are you sure you want to delete # %s?', $userAttribute['UserAttribute']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Attribute'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
