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
			'name' => 'UserAttributeMoveForm' . $userAttribute['UserAttributeSetting']['id'],
			'url' => array(
				'plugin' => 'user_attributes',
				'controller' => 'user_attributes',
				'action' => 'move',
				$userAttribute['UserAttributeSetting']['id']
			),
		)); ?>

	<?php echo $this->Form->hidden('UserAttributeSetting.id', array(
			'value' => $userAttribute['UserAttributeSetting']['id'],
		)); ?>

	<?php $this->Form->unlockField('UserAttributeSetting.row_' . $userAttribute['UserAttributeSetting']['id']); ?>
	<?php echo $this->Form->hidden('UserAttributeSetting.row_' . $userAttribute['UserAttributeSetting']['id'], array(
			'value' => '',
		)); ?>

	<?php $this->Form->unlockField('UserAttributeSetting.col_' . $userAttribute['UserAttributeSetting']['id']); ?>
	<?php echo $this->Form->hidden('UserAttributeSetting.col_' . $userAttribute['UserAttributeSetting']['id'], array(
			'value' => '',
		)); ?>

	<?php $this->Form->unlockField('UserAttributeSetting.weight_' . $userAttribute['UserAttributeSetting']['id']); ?>
	<?php echo $this->Form->hidden('UserAttributeSetting.weight_' . $userAttribute['UserAttributeSetting']['id'], array(
			'value' => '',
		)); ?>

	<button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="glyphicon glyphicon-cog"> </span>
	</button>

	<ul class="dropdown-menu">
		<?php $rowInputForm = 'UserAttributeSettingRow' . $userAttribute['UserAttributeSetting']['id']; ?>
		<?php $colInputForm = 'UserAttributeSettingCol' . $userAttribute['UserAttributeSetting']['id']; ?>
		<?php $weightInputForm = 'UserAttributeSettingWeight' . $userAttribute['UserAttributeSetting']['id']; ?>
		<?php $submit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttribute['UserAttributeSetting']['id'] . ']\')[0].submit()'; ?>

		<li>
			<a href="" onclick="<?php echo '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($userAttribute['UserAttributeSetting']['weight'] - 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-up"> <?php echo __d('user_attributes', 'Go to Up') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($userAttribute['UserAttributeSetting']['weight'] + 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-down"> <?php echo __d('user_attributes', 'Go to Down') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $colInputForm . '\')[0].value = \'' . ($userAttribute['UserAttributeSetting']['weight'] - 1) . '\'; ' . $submit . ';'; ?>">
				<span class="glyphicon glyphicon-arrow-left"> <?php echo __d('user_attributes', 'Go to Left') ?></span>
			</a>
		</li>
		<li>
			<a href="" onclick="<?php echo '$(\'#' . $colInputForm . '\')[0].value = \'' . ($userAttribute['UserAttributeSetting']['weight'] + 1) . '\'; ' . $submit . ';'; ?>">
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
