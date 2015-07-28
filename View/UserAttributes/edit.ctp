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
?>

<?php $this->assign('title', __d('user_attributes', 'User attributes setting')); ?>

<div class="panel panel-default">
	<div class="panel-body">
		<?php echo $this->element('UserAttributes.switch_language', array('prefix' => 'user_attribute_')); ?>

		<?php echo $this->Form->create(null, array('novalidate' => true)); ?>
			<div class="tab-content">
				<?php foreach ($languages as $langId => $langCode) : ?>
					<div id="user_attribute_<?php echo $langCode; ?>"
							class="tab-pane <?php echo (Configure::read('Config.language') === $langCode ? ' active' : ''); ?>">

						<?php echo $this->element('UserAttributes/edit_form', array(
								'langId' => $langId,
								'userAttribute' => $this->data[$langId]
							)); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>

</div>

