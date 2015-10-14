<?php
/**
 * UserAttribute index col template
 *   - $row: UserAttributeLayout.row
 *   - $col: UserAttributeLayout.row
 *   - $layout: UserAttributeLayout
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if (isset($userAttributes[$row][$col])) : ?>
	<div class="col-xs-12 col-sm-<?php echo (12 / $layout['UserAttributeLayout']['col']); ?>">
		<?php foreach ($userAttributes[$row][$col] as $userAttribute) : ?>
			<ul class="user-attribute-edit">
				<li class="list-group-item clearfix">
					<div class="pull-left user-attribute-display">
						<?php echo $this->element('UserAttributes/display_setting', array('userAttribute' => $userAttribute)); ?>
					</div>
					<div class="pull-left user-attribute-move">
						<?php echo $this->element('UserAttributes/move_setting', array('userAttribute' => $userAttribute)); ?>
					</div>

					<div class="pull-left">
						<?php echo h($userAttribute['UserAttribute']['name']); ?>
						<?php if ($userAttribute['UserAttributeSetting']['required']) : ?>
							<?php echo $this->element('NetCommons.required'); ?>
						<?php endif; ?>
					</div>

					<div class="pull-right">
						<a href="<?php echo $this->NetCommonsHtml->url(array('action' => 'edit',  h($userAttribute['UserAttribute']['key']))); ?>"
							class="btn btn-xs btn-primary">

							<span class="glyphicon glyphicon-edit"> </span>
						</a>
					</div>
				</li>
			</ul>
		<?php endforeach; ?>
	</div>
<?php endif;
