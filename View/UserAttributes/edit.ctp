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

echo $this->NetCommonsHtml->css('/user_attributes/css/style.css');

echo $this->NetCommonsHtml->script('/user_attributes/js/user_attributes.js');
?>

<div class="panel panel-default" ng-controller="UserAttributes">
	<?php echo $this->Form->create('UserAttribute', array('novalidate' => true)); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('user-attributes-'); ?>

		<div class="tab-content">
			<?php echo $this->element('UserAttributes/edit_form'); ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<a class="btn btn-default btn-workflow" href="<?php echo $this->NetCommonsHtml->url(array('action' => 'index')); ?>">
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
