<?php
/**
 * Element of Categories edit form
 *   - $categories:
 *       The results data of Category->getCategories(), and The formatter is camelized data.
 *   - $cancelUrl: Cancel url.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
if (! isset($this->request->data['UserAttributeChoice'])) {
	$this->request->data['UserAttributeChoice'] = array();
}
$this->request->data['UserAttributeChoiceMap'] = Hash::combine($this->request->data['UserAttributeChoice'], '{n}.{n}.id', '{n}.{n}');

//Formヘルパーにセット
foreach ($this->request->data['UserAttributeChoiceMap'] as $choiceMap) {
	if (! $choiceMap['id']) {
		continue;
	}

	echo $this->NetCommonsForm->hidden('UserAttributeChoiceMap.' . $choiceMap['id'] . '.id');
	echo $this->NetCommonsForm->hidden('UserAttributeChoiceMap.' . $choiceMap['id'] . '.language_id');
	echo $this->NetCommonsForm->hidden('UserAttributeChoiceMap.' . $choiceMap['id'] . '.user_attribute_id');
	echo $this->NetCommonsForm->hidden('UserAttributeChoiceMap.' . $choiceMap['id'] . '.key');
	echo $this->NetCommonsForm->hidden('UserAttributeChoiceMap.' . $choiceMap['id'] . '.value');
}
$this->NetCommonsForm->unlockField('UserAttributeChoice');
?>

<div class="panel panel-default">

	<div class="panel-body">
		<div class="form-group user-attribute-choices-form text-right">
			<button type="button" class="btn btn-success btn-sm" ng-click="add()">
				<span class="glyphicon glyphicon-plus"> </span>
			</button>
		</div>

		<div ng-hide="userAttributeChoices.length">
			<p><?php echo __d('user_attributes', 'Not choices found.'); ?></p>
		</div>

		<div class="pre-scrollable user-attribute-scrollable" ng-show="userAttributeChoices.length">
			<?php foreach (array_keys($languages) as $langId) : ?>
				<article class="form-group user-attribute-choices-form" ng-repeat="choice in userAttributeChoices track by $index" ng-show="activeLangId === '<?php echo $langId ?>'">
					<div class="input-group input-group-sm">
						<div class="input-group-btn">
							<button type="button" class="btn btn-default"
									ng-click="move('up', $index)" ng-disabled="$first">
								<span class="glyphicon glyphicon-arrow-up"></span>
							</button>

							<button type="button" class="btn btn-default"
									ng-click="move('down', $index)" ng-disabled="$last">
								<span class="glyphicon glyphicon-arrow-down"></span>
							</button>
						</div>

						<?php
							foreach (['id', 'language_id', 'user_attribute_id', 'key', 'value'] as $field) {
								echo '<input type="hidden" ' .
											'name="data[UserAttributeChoice][{{$index+1}}][' . h($langId) . '][' . $field . ']" ' .
											'ng-value="choice._' . h($langId) . '.' . $field . '">';
							}
						?>
						<input type="hidden" name="data[UserAttributeChoice][{{$index+1}}][<?php echo h($langId); ?>][weight]"
								ng-value="{{$index+1}}">
						<input type="text" name="data[UserAttributeChoice][{{$index+1}}][<?php echo h($langId); ?>][name]"
								ng-model="choice._<?php echo h($langId); ?>.name" class="form-control" required>

						<div class="input-group-btn">
							<button type="button" class="btn btn-default" tooltip="<?php echo __d('net_commons', 'Delete'); ?>"
									ng-click="delete($index)">
								<span class="glyphicon glyphicon-remove"> </span>
							</button>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php foreach (array_keys($languages) as $langId) : ?>
			<div class="has-error">
				<?php echo $this->NetCommonsForm->error('UserAttributeChoice.' . $langId . '.name', null,
						array('class' => 'help-block', 'ng-show' => 'activeLangId === \'' . $langId . '\'')); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>

