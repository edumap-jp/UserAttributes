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

foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) {
	$languageId = $userAttribute['language_id'];
	if (! isset($languages[$languageId])) {
		continue;
	}

	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.id');
	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.key');
	echo $this->NetCommonsForm->hidden('UserAttribute.' . $index . '.language_id');
	echo $this->NetCommonsForm->input('UserAttribute.' . $index . '.' . 'name', array(
		'type' => 'text',
		'label' => __d('user_attributes', 'Item name') . $this->element('NetCommons.required'),
		'div' => array(
			'class' => 'form-group',
			'ng-show' => 'activeLangId === \'' . (string)$languageId . '\'',
			'ng-cloak' => ' '
		)
	));
}

echo $this->NetCommonsForm->hidden('UserAttributeSetting.row');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.col');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.weight');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.display');
echo $this->NetCommonsForm->hidden('UserAttributeSetting.is_systemized');
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.display_label', array(
	'label' => __d('user_attributes', 'Show the item name')
));
echo $this->DataTypeForm->selectDataTypes('UserAttributeSetting.data_type_key', array(
	'label' => __d('user_attributes', 'Input type'),
));
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.required', array(
	'label' => __d('user_attributes', 'Designate as required items')
));
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.only_administrator', array(
	'label' => __d('user_attributes', 'To prohibit the reading and writing of non-members administrator')
));
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_publicity', array(
	'label' => __d('user_attributes', 'Enable individual public/private setting')
));
echo $this->NetCommonsForm->inlineCheckbox('UserAttributeSetting.self_email_reception_possibility', array(
	'label' => __d('user_attributes', 'Enable individual email receipt / non-receipt setting')
));

foreach ($this->request->data['UserAttribute'] as $index => $userAttribute) {
	$languageId = $userAttribute['language_id'];
	if (! isset($languages[$languageId])) {
		continue;
	}
	echo $this->NetCommonsForm->input('UserAttribute.' . $index . '.' . 'description', array(
		'type' => 'textarea',
		'label' => __d('user_attributes', 'Description'),
		'div' => array(
			'class' => 'form-group',
			'ng-show' => 'activeLangId === \'' . (string)$languageId . '\'',
			'ng-cloak' => ' '
		)
	));
}
