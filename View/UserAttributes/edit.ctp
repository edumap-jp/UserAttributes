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

$camelizeData['userAttributeSetting'] = NetCommonsAppController::camelizeKeyRecursive($this->data['UserAttributeSetting']);
?>

<div class="panel panel-default" ng-controller="UserAttributes" ng-init='initialize(<?php echo h(json_encode($camelizeData)) ?>)'>
	<?php echo $this->NetCommonsForm->create('UserAttribute'); ?>

	<div class="panel-body">
		<?php echo $this->SwitchLanguage->tablist('user-attributes-'); ?>

		<div class="tab-content">
			<?php echo $this->element('UserAttributes/edit_form'); ?>
		</div>
	</div>

	<div class="panel-footer text-center">
		<?php echo $this->Button->cancelAndSave(
				__d('net_commons', 'Cancel'),
				__d('net_commons', 'OK'),
				$this->NetCommonsHtml->url(array('action' => 'index'))
			); ?>
	</div>

	<?php echo $this->NetCommonsForm->end(); ?>
</div>

<?php if ($this->request->params['action'] === 'edit' && ! $this->data['UserAttributeSetting']['is_systemized']) : ?>
	<?php echo $this->element('UserAttributes/delete_form'); ?>
<?php endif;
