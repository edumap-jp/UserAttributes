<?php
/**
 * Move UserAttribute element
 *   - $userAttribute: userAttribute
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="btn-group">
	<?php echo $this->Form->create(null, array(
			'novalidate' => true,
			'name' => 'UserAttributeForm' . $userAttribute['UserAttribute']['id'],
			'url' => array(
				'plugin' => 'user_attributes',
				'controller' => 'user_attributes',
				'action' => 'move',
				$userAttribute['UserAttribute']['id']
			),
		)); ?>

	<?php echo $this->Form->hidden('UserAttribute.id', array(
			'value' => $userAttribute['UserAttribute']['id'],
		)); ?>

	<?php $this->Form->unlockField('UserAttribute.row_' . $userAttribute['UserAttribute']['id']); ?>
	<?php echo $this->Form->hidden('UserAttribute.row_' . $userAttribute['UserAttribute']['id'], array(
			'value' => '',
		)); ?>

	<?php $this->Form->unlockField('UserAttribute.col_' . $userAttribute['UserAttribute']['id']); ?>
	<?php echo $this->Form->hidden('UserAttribute.col_' . $userAttribute['UserAttribute']['id'], array(
			'value' => '',
		)); ?>

	<?php $this->Form->unlockField('UserAttribute.weight_' . $userAttribute['UserAttribute']['id']); ?>
	<?php echo $this->Form->hidden('UserAttribute.weight_' . $userAttribute['UserAttribute']['id'], array(
			'value' => '',
		)); ?>

	<button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="glyphicon glyphicon-cog"> </span>
	</button>

	<ul class="dropdown-menu">
		<?php $rowInputForm = 'UserAttributeRow' . $userAttribute['UserAttribute']['id']; ?>
		<?php $colInputForm = 'UserAttributeCol' . $userAttribute['UserAttribute']['id']; ?>
		<?php $weightInputForm = 'UserAttributeWeight' . $userAttribute['UserAttribute']['id']; ?>
		<?php $submit = '$(\'form[name=' . 'UserAttributeForm' . $userAttribute['UserAttribute']['id'] . ']\')[0].submit()'; ?>

		<li>
			<a href="" onclick="<?php echo '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($userAttribute['UserAttribute']['weight'] - 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-up"> <?php echo __d('user_attributes', 'Go to Up') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($userAttribute['UserAttribute']['weight'] + 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-down"> <?php echo __d('user_attributes', 'Go to Down') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $colInputForm . '\')[0].value = \'' . ($userAttribute['UserAttribute']['weight'] - 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-left"> <?php echo __d('user_attributes', 'Go to Left') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $colInputForm . '\')[0].value = \'' . ($userAttribute['UserAttribute']['weight'] + 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-right"> <?php echo __d('user_attributes', 'Go to Right') ?></span>
			</a>
		</li>

		<li class="divider"></li>

		<?php foreach ($userAttributeLayouts as $row) : ?>
			<li>
				<a href="" onclick="<?php echo '$(\'#' . $rowInputForm . '\')[0].value = \'' . ($row['UserAttributeLayout']['id']) . '\'; ' . $submit . ';'; ?>">
					<?php echo sprintf(__d('user_attributes', 'Go to %s row'), $row['UserAttributeLayout']['id']); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php echo $this->Form->end(); ?>

</div>
