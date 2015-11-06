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

echo $this->NetCommonsForm->hidden('UserAttributeSetting.row');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.col');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.weight');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.display');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.is_systemized');
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
 * * システム項目の場合、disabled
 * * 編集の場合、disabled
 */
if ($this->request->data['UserAttributeSetting']['is_systemized'] || $this->params['action'] === 'edit') {
	echo $this->NetCommonsForm->hidden('UserAttributeSetting.data_type_key');
	$fieldName = 'UserAttributeSetting.data_type_key_';
} else {
	$fieldName = 'UserAttributeSetting.data_type_key';
}
echo $this->DataTypeForm->selectDataTypes('UserAttributeSetting.data_type_key', array(
	'label' => __d('user_attributes', 'Input type'),
	'div' => false,
	'ng-disabled' => ((int)$this->request->data['UserAttributeSetting']['is_systemized'] || $this->params['action'] === 'edit'),
	'ng-model' => 'userAttributeSetting.dataTypeKey',
	'ng-value' => 'userAttributeSetting.dataTypeKey',
));

/**
 * 選択肢リスト
 * * システム項目の場合、非表示
 * * ラジオ、セレクト、チェックボックスの場合、ng-show
 */
if (! $this->request->data['UserAttributeSetting']['is_systemized']) {
	echo '<div ng-show="(userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_RADIO . '\' || ' .
						'userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_CHECKBOX . '\' || ' .
						'userAttributeSetting.dataTypeKey === \'' . DataType::DATA_TYPE_SELECT . '\')">';

	echo $this->element('UserAttributes.UserAttributes/choice_edit_form');

	echo '</div>';
}

echo '</div>';

/**
 * 必須項目とする
 * * システム項目の場合、disabled
 * * ラベルタイプの場合、disabled
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.required', array(
	'label' => __d('user_attributes', 'Designate as required items'),
	'ng-disabled' => '(' . (int)$this->request->data['UserAttributeSetting']['is_systemized'] . ' || userAttributeSetting.dataTypeKey === "' . DataType::DATA_TYPE_LABEL . '")',
));

/**
 * 会員管理者以外の読み書きを禁ずる
 * * システム項目の場合、disabled
 * * ラベルタイプの場合、disabled
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.only_administrator', array(
	'label' => __d('user_attributes', 'To prohibit the reading and writing of non-members administrator'),
	'ng-disabled' => '(' . (int)$this->request->data['UserAttributeSetting']['is_systemized'] . ' || userAttributeSetting.dataTypeKey === "' . DataType::DATA_TYPE_LABEL . '")',
));

/**
 * 各自で公開・非公開を設定可能にする
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_publicity', array(
	'label' => __d('user_attributes', 'Enable individual public/private setting')
));

/**
 * 各自でメールの受信可否を設定可能にする
 * * システム項目の場合、disabled
 * * 入力タイプがメール以外、disabled
 */
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_email_reception_possibility', array(
	'label' => __d('user_attributes', 'Enable individual email receipt / non-receipt setting'),
	'ng-disabled' => '(' . (int)$this->request->data['UserAttributeSetting']['is_systemized'] . ' || userAttributeSetting.dataTypeKey !== "' . DataType::DATA_TYPE_EMAIL . '")',
));

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
