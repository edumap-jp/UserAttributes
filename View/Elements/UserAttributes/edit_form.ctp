<?php
/**
 * UserAttribute edit form template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsForm->hidden('UserAttributeSetting.id');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.row');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.col');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.weight');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.display');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.is_system');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.user_attribute_key');

foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) {
	$languageId = $userAttribute['language_id'];
	if (! isset($languages[$languageId])) {
		continue;
	}

	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.id');
	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.key');
	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.language_id');

	echo '<div class="form-group" ng-show="activeLangId === \'' . (string)$languageId . '\'" ng-cloak>';
	echo $this->NetCommonsForm->input('UserAttribute.' . $index . '.' . 'name', array(
		'type' => 'text',
		'label' => $this->SwitchLanguage->inputLabel(__d('user_attributes', 'Item name'), $languageId),
		'error' => array(
			'ng-show' => 'activeLangId === \'' . (string)$languageId . '\'',
		),
		'required' => true,
	));
	echo '</div>';
}

/**
 * 項目名を表示する
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.display_label', array(
	'label' => __d('user_attributes', 'Show the item name')
));

echo '<div class="form-group">';

/**
 * 入力タイプ
 *
 * * システム項目の場合、disabled
 * * 編集の場合、disabled
 */
if ($this->request->data['UserAttributeSetting']['is_system'] || $this->params['action'] === 'edit') {
	echo $this->NetCommonsForm->hidden('UserAttributeSetting.data_type_key');
}
echo $this->DataTypeForm->selectDataTypes('UserAttributeSetting.data_type_key', array(
	'label' => __d('user_attributes', 'Input type'),
	'div' => false,
	'ng-disabled' => ((int)$this->request->data['UserAttributeSetting']['is_system'] || $this->params['action'] === 'edit'),
	'ng-model' => 'userAttributeSetting.dataTypeKey',
	'ng-value' => 'userAttributeSetting.dataTypeKey',
));

/**
 * 選択肢リスト
 *
 * * システム項目の場合、非表示
 * * ラジオ、セレクト、チェックボックスの場合、ng-show
 */
if (! $this->request->data['UserAttributeSetting']['is_system']) {
	echo '<div ng-show="(userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_RADIO . '\' || ' .
						'userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_CHECKBOX . '\' || ' .
						'userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_SELECT . '\')">';

	echo $this->element('UserAttributes.UserAttributes/choice_edit_form');

	echo '</div>';
}
echo '</div>';

/**
 * 多言語入力とする
 *
 * * システム項目の場合、disabled
 * * テキスト・テキストエリアタイプ以外の場合、disabled
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.is_multilingualization', array(
	'label' => __d('user_attributes', 'Designate as multi-language items'),
	'ng-disabled' => '(' . (int)($this->params['action'] === 'edit' || $this->request->data['UserAttributeSetting']['is_system']) . ' || ' .
							'userAttributeSetting.dataTypeKey !== "' . DataType::DATA_TYPE_TEXT . '" && userAttributeSetting.dataTypeKey !== "' . DataType::DATA_TYPE_TEXTAREA . '")',
));

/**
 * 必須項目とする
 *
 * * システム項目の場合、disabled
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.required', array(
	'label' => __d('user_attributes', 'Designate as required items'),
	'ng-disabled' => '(' . (int)$this->request->data['UserAttributeSetting']['is_system'] . ')',
));

/**
 * 読み取り不可項目とする（管理者のみ読める）
 *
 * * パスワード：チェックON固定
 * * ハンドル・アバター：チェックOFF固定
 * * ラベルタイプ以外で書き込み可：チェックOFF固定
 * * パスワード・ハンドル・アバターの場合、disable
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.only_administrator_readable', array(
	'label' => __d('user_attributes', 'To prohibit the reading of non-members administrator'),
	'ng-click' => 'onlyAdministratorClick($event, "' . $this->NetCommonsHtml->domId('UserAttributeSetting.only_administrator_readable') . '", "' .
												$this->NetCommonsHtml->domId('UserAttributeSetting.only_administrator_editable') . '")',
	'ng-disabled' => '(userAttributeSetting.userAttributeKey === "' . UserAttribute::HANDLENAME_FIELD . '" || ' .
						'userAttributeSetting.userAttributeKey === "' . UserAttribute::PASSWORD_FIELD . '" || ' .
						'userAttributeSetting.userAttributeKey === "' . UserAttribute::AVATAR_FIELD . '")',
));

/**
 * 書き込み不可項目とする（管理者のみ書ける）
 *
 * * ラベルタイプの場合、disabled
 * * 読み取り不可：チェックON固定
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.only_administrator_editable', array(
	'label' => __d('user_attributes', 'To prohibit the writing of non-members administrator'),
	'ng-click' => 'onlyAdministratorClick($event, "' . $this->NetCommonsHtml->domId('UserAttributeSetting.only_administrator_readable') . '", "' .
												$this->NetCommonsHtml->domId('UserAttributeSetting.only_administrator_editable') . '")',
	'ng-disabled' => '(userAttributeSetting.dataTypeKey === "' . DataType::DATA_TYPE_LABEL . '")',
));

/**
 * 各自で公開・非公開を設定可能にする
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_public_setting', array(
	'label' => __d('user_attributes', 'Enable individual public/private setting')
));

/**
 * 各自でメールの受信可否を設定可能にする
 * * システム項目の場合、disabled
 * * 入力タイプがメール以外、disabled
 */
echo '<div class="form-group" ' .
		'ng-hide="(' . (int)$this->request->data['UserAttributeSetting']['is_system'] . ' || userAttributeSetting.dataTypeKey !== \'' . DataType::DATA_TYPE_EMAIL . '\')">';
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_email_setting', array(
	'label' => __d('user_attributes', 'Enable individual email receipt / non-receipt setting'),
	'ng-disabled' => '(' . (int)$this->request->data['UserAttributeSetting']['is_system'] . ' || userAttributeSetting.dataTypeKey !== "' . DataType::DATA_TYPE_EMAIL . '")',
	'div' => false,
));
echo '</div>';


foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) {
	$languageId = $userAttribute['language_id'];
	if (! isset($languages[$languageId])) {
		continue;
	}
	echo $this->NetCommonsForm->input('UserAttribute.' . $index . '.' . 'description', array(
		'type' => 'textarea',
		'label' => $this->SwitchLanguage->inputLabel(__d('user_attributes', 'Description'), $languageId),
		'rows' => '3',
		'div' => array(
			'class' => 'form-group',
			'ng-show' => 'activeLangId === \'' . (string)$languageId . '\'',
			'ng-cloak' => ' '
		),
	));
}
