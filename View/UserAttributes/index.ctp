<?php
/**
 * UserAttribute index template
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

<?php foreach ($userAttributeLayouts as $layout) : ?>
	<?php $row = $layout['UserAttributeLayout']['id']; ?>

	<div class="panel panel-default" >
		<div class="panel-heading clearfix">
			<div class="pull-left">
				<strong><?php echo sprintf(__d('user_attributes', '%s row'), $row); ?></strong>
			</div>
			<div class="pull-right">
				<?php echo $this->element('UserAttributes/edit_col', array('layout' => $layout)); ?>
			</div>
		</div>

		<div class="panel-body">
			<p class="text-right">
				<a class="btn btn-sm btn-success" href="<?php echo $this->Html->url('/user_attributes/user_attributes/add/' . $row . '/'); ?>">
					<span class="glyphicon glyphicon-plus"> </span>
				</a>
			</p>

			<div class="row">
				<?php for($col = 1; $col <= $layout['UserAttributeLayout']['col']; $col++) : ?>
					<div class="col-xs-12 col-sm-<?php echo (12 / $layout['UserAttributeLayout']['col']); ?>">
						<?php foreach ($userAttributes[$row][$col] as $userAttribute) : ?>
							<ul class="user-attribute-edit">
								<li class="list-group-item clearfix">
									<div class="pull-left" style="margin-right: 10px;">
										<?php echo $this->element('UserAttributes/move_settings', array('userAttribute' => $userAttribute)); ?>
									</div>

									<div class="pull-left">
										<?php echo h($userAttribute['UserAttribute']['name']); ?>
										<?php if ($userAttribute['UserAttribute']['required']) : ?>
											<?php echo $this->element('NetCommons.required'); ?>
										<?php endif; ?>
									</div>

									<div class="pull-right">
										<a href="<?php echo $this->Html->url('/user_attributes/user_attributes/edit/' . h($userAttribute['UserAttribute']['key'])); ?>"
											class="btn btn-xs btn-primary">

											<span class="glyphicon glyphicon-edit"> </span>
										</a>
									</div>
								</li>
							</ul>
						<?php endforeach; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
<?php endforeach;
