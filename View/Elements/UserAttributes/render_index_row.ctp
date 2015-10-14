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
?>

<div class="panel panel-default">
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
			<a class="btn btn-sm btn-success" href="<?php echo $this->NetCommonsHtml->url(array('action' => 'add', $row)); ?>">
				<span class="glyphicon glyphicon-plus"> </span>
			</a>
		</p>

		<div class="row">
			<?php for($col = 1; $col <= $layout['UserAttributeLayout']['col']; $col++) : ?>
				<?php echo $this->element('UserAttributes/render_index_col',
						array('row' => $row, 'col' => $col, 'layout' => $layout)); ?>
			<?php endfor; ?>
		</div>
	</div>
</div>
