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
?>

<?php echo $this->MessageFlash->description(__d('user_attributes', 'You can add, edit, delete and change the display order of items of user profile.<br>The items to be displayed to other members are controled at &#039;User role plugin > Information Policy&#039;.')); ?>

<?php echo $this->UserAttributeLayout->renderRow('UserAttributes/render_index_row');
