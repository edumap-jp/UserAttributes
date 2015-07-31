<?php
/**
 * UserAttribute edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->Html->css(
	array(
		'/user_attributes/css/style.css'
	),
	array('plugin' => false)
);

echo $this->Html->script(
	array(
		'/user_attributes/js/user_attributes.js'
	),
	array('plugin' => false)
);
?>

<?php $this->assign('title', __d('user_attributes', 'User attributes setting')); ?>

<div class="panel panel-default">
	<?php echo $this->Form->create(null, array('novalidate' => true)); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('user-attributes-'); ?>

		<div class="tab-content">
			<?php foreach ($this->data as $index => $userAttribute) : ?>
				<div id="user-attributes-<?php echo $userAttribute['UserAttribute']['language_id']; ?>"
						class="tab-pane<?php echo ($activeLangId === $userAttribute['UserAttribute']['language_id'] ? ' active' : ''); ?>">

					<?php echo $this->element('UserAttributes/edit_form', array(
							'index' => $index,
							//'userAttribute' => $this->data[$langId]
						)); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<a class="btn btn-default btn-workflow" href="<?php echo $this->Html->url('/user_attributes/user_attributes/index/'); ?>">
			<span class="glyphicon glyphicon-remove"></span>
			<?php echo __d('net_commons', 'Cancel'); ?>
		</a>

		<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save',
			)); ?>
	</div>

	<?php echo $this->Form->end(); ?>
</div>

<?php if ($this->request->params['action'] === 'edit') : ?>
	<?php echo $this->element('UserAttributes/delete_form'); ?>
<?php endif;
