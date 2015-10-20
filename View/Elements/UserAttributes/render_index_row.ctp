<?php
/**
 * UserAttribute index row template
 *   - $row: UserAttributeLayout.row
 *   - $layout: UserAttributeLayout
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$row = $layout['UserAttributeLayout']['id'];
$col = $layout['UserAttributeLayout']['col'];
?>

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<strong><?php echo sprintf(__d('user_attributes', '%s row'), $row); ?></strong>
		</div>
		<div class="pull-right">
			<?php echo $this->UserAttributeLayout->editCol($layout); ?>
		</div>
	</div>

	<div class="panel-body">
		<p class="text-right">
			<?php echo $this->Button->addLink('', array('action' => 'add', $row, $col), array('iconSize' => 'btn-sm')); ?>
		</p>

		<div class="row">
			<?php echo $this->UserAttributeLayout->renderCol($layout); ?>
		</div>
	</div>
</div>
