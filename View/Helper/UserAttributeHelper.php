<?php
/**
 * UserAttribute Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * 会員項目設定で使用するヘルパー
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttribute\View\Helper
 */
class UserAttributeHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
		'NetCommons.NetCommonsForm'
	);

/**
 * 表示列の変更HTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @return string HTML
 */
	public function editCol($layout) {
		$output = '';

		$url = $this->NetCommonsHtml->url(array(
			'controller' => 'user_attribute_layouts',
			'action' => 'edit',
			$layout['UserAttributeLayout']['id']
		));
		$output .= $this->NetCommonsForm->create(null, array('url' => $url));

		$output .= $this->NetCommonsForm->hidden('UserAttributeLayout.id',
				array('value' => $layout['UserAttributeLayout']['id']));

		$options = array(
			'1' => __d('user_attributes', '%s Col', 1),
			'2' => __d('user_attributes', '%s Cols', 2),
		);
		$output .= $this->NetCommonsForm->select('UserAttributeLayout.col', $options, array(
			'value' => $layout['UserAttributeLayout']['col'],
			'class' => 'form-control',
			'empty' => false,
			'onchange' => 'submit()'
		));

		$output .= $this->NetCommonsForm->end();
		return $output;
	}

/**
 * 表示・非表示の変更HTMLを出力する
 *
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	public function displaySetting($userAttribute) {
		$output = '';

		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];

		$output .= $this->NetCommonsForm->create(null, array(
			'name' => 'UserAttributeDidplayForm' . $userAttrSettingId,
			'url' => $this->NetCommonsHtml->url(array(
				'controller' => 'user_attribute_settings',
				'action' => 'display',
				$userAttrSettingId
			)),
		));

		$output .= $this->NetCommonsForm->hidden('UserAttributeSetting.id', array(
			'value' => $userAttrSettingId,
		));

		if ($userAttribute['UserAttributeSetting']['display']) {
			$output .= $this->NetCommonsForm->hidden('UserAttributeSetting.display', array('value' => false));
			$buttonIcon = 'glyphicon-eye-open';
			$active = ' active';
		} else {
			$output .= $this->NetCommonsForm->hidden('UserAttributeSetting.display', array('value' => true));
			$buttonIcon = 'glyphicon-eye-close';
			$active = '';
		}
		$output .= $this->Button->save('<span class="glyphicon ' . $buttonIcon . '"> </span>', array(
			'class' => 'btn btn-xs btn-default' . $active
		));

		$output .= $this->NetCommonsForm->end();
		return $output;
	}

/**
 * 項目の移動HTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	public function moveSetting($layout, $userAttribute) {
		$output = '';

		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];

		$output .= $this->NetCommonsForm->create(null, array(
			'name' => 'UserAttributeMoveForm' . $userAttrSettingId,
			'url' => $this->NetCommonsHtml->url(array(
				'controller' => 'user_attribute_settings',
				'action' => 'move',
				$userAttrSettingId
			)),
		));

		$output .= $this->NetCommonsForm->hidden('UserAttributeSetting.id',
				array('value' => $userAttrSettingId));

		$fields = array(
			'UserAttributeSetting.row_' . $userAttrSettingId,
			'UserAttributeSetting.col_' . $userAttrSettingId,
			'UserAttributeSetting.weight_' . $userAttrSettingId
		);
		foreach ($fields as $field) {
			$this->NetCommonsForm->unlockField($field);
			$output .= $this->NetCommonsForm->hidden($field, array('value' => ''));
		}

		$output .= '<button type="button" ' .
							'class="btn btn-xs btn-default dropdown-toggle" ' .
							'data-toggle="dropdown" ' .
							'aria-haspopup="true" ' .
							'aria-expanded="false" ' .
							'ng-disabled="sending">' .
					__d('user_attributes', 'Move') .
					' <span class="caret"></span>' .
				'</button>';

		$output .= '<ul class="dropdown-menu">';
		$output .= $this->__moveSettingTopMenu($layout, $userAttribute);
		$output .= $this->__moveSettingBottomMenu($layout, $userAttribute);
		$output .= $this->__moveSettingLeftMenu($layout, $userAttribute);
		$output .= $this->__moveSettingRightMenu($layout, $userAttribute);

		//区切り線
		$output .= '<li class="divider"></li>';

		$output .= $this->__moveSettingRowMenu($layout, $userAttribute);

		$output .= '</ul>';

		$output .= $this->NetCommonsForm->end();
		return $output;
	}

/**
 * 項目の移動メニューHTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	private function __moveSettingTopMenu($layout, $userAttribute) {
		$output = '';

		//データを変数にセット
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];
		$weight = (int)$userAttribute['UserAttributeSetting']['weight'];
		$row = (int)$layout['UserAttributeLayout']['id'];
		$col = (int)$userAttribute['UserAttributeSetting']['col'];

		//HTMLタグセット
		$colInputForm = 'UserAttributeSettingCol' . $userAttrSettingId;
		$weightInputForm = 'UserAttributeSettingWeight' . $userAttrSettingId;
		$formSubmit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttrSettingId . ']\')[0].submit()';
		$moveMenuTag =
			'<li%s>' .
				'<a href="" onclick="%s"> ' .
					'<span class="glyphicon%s">%s</span>' .
				'</a>' .
			'</li>';

		//上に移動
		if ($weight === 1) {
			if ((int)$layout['UserAttributeLayout']['col'] === 2 ||
					$col === 1 || ! isset($this->_View->viewVars['userAttributes'][$row][1])) {
				$disabled = ' class="disabled"';
				$onclick = '';
			} else {
				$disabled = '';

				$updWeight = count($this->_View->viewVars['userAttributes'][$row][($col - 1)]);
				$onclick = '$(\'#' . $colInputForm . '\')[0].value = \'' . ($col - 1) . '\'; ';
				$onclick .= '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($updWeight) . '\'; ';
				$onclick .= $formSubmit . ';';
			}
		} else {
			$disabled = '';
			$onclick = '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($weight - 1) . '\'; ' . $formSubmit . ';';
		}
		$output .= sprintf($moveMenuTag, $disabled, $onclick, ' glyphicon-arrow-up', __d('user_attributes', 'Go to Up'));

		return $output;
	}

/**
 * 項目の移動メニューHTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	private function __moveSettingBottomMenu($layout, $userAttribute) {
		$output = '';

		//データを変数にセット
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];
		$weight = (int)$userAttribute['UserAttributeSetting']['weight'];
		$row = (int)$layout['UserAttributeLayout']['id'];
		$col = (int)$userAttribute['UserAttributeSetting']['col'];

		//HTMLタグセット
		$colInputForm = 'UserAttributeSettingCol' . $userAttrSettingId;
		$weightInputForm = 'UserAttributeSettingWeight' . $userAttrSettingId;
		$formSubmit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttrSettingId . ']\')[0].submit()';
		$moveMenuTag =
			'<li%s>' .
				'<a href="" onclick="%s"> ' .
					'<span class="glyphicon%s">%s</span>' .
				'</a>' .
			'</li>';

		//下に移動
		if ($weight === count($this->_View->viewVars['userAttributes'][$row][$col])) {
			if ((int)$layout['UserAttributeLayout']['col'] === 2 ||
					$col === 2 || ! isset($this->_View->viewVars['userAttributes'][$row][2])) {
				$disabled = ' class="disabled"';
				$onclick = '';
			} else {
				$disabled = '';

				$updWeight = 2;
				$onclick = '$(\'#' . $colInputForm . '\')[0].value = \'' . ($col + 1) . '\'; ';
				$onclick .= '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($updWeight) . '\'; ';
				$onclick .= $formSubmit . ';';
			}
		} else {
			$disabled = '';
			$onclick = '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($weight + 1) . '\'; ' . $formSubmit . ';';
		}
		$output .= sprintf($moveMenuTag, $disabled, $onclick, ' glyphicon-arrow-down', __d('user_attributes', 'Go to Down'));

		return $output;
	}

/**
 * 項目の移動メニューHTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	private function __moveSettingLeftMenu($layout, $userAttribute) {
		$output = '';

		//データを変数にセット
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];
		$weight = (int)$userAttribute['UserAttributeSetting']['weight'];
		$row = (int)$layout['UserAttributeLayout']['id'];
		$col = (int)$userAttribute['UserAttributeSetting']['col'];

		//HTMLタグセット
		$colInputForm = 'UserAttributeSettingCol' . $userAttrSettingId;
		$weightInputForm = 'UserAttributeSettingWeight' . $userAttrSettingId;
		$formSubmit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttrSettingId . ']\')[0].submit()';
		$moveMenuTag =
			'<li%s>' .
				'<a href="" onclick="%s"> ' .
					'<span class="glyphicon%s">%s</span>' .
				'</a>' .
			'</li>';

		if ((int)$layout['UserAttributeLayout']['col'] === 2) {
			//左に移動
			if ($col === 1) {
				$disabled = ' class="disabled"';
				$onclick = '';
			} else {
				$disabled = '';
				$onclick = '$(\'#' . $colInputForm . '\')[0].value = \'' . ($col - 1) . '\'; ';
				if (! isset($this->_View->viewVars['userAttributes'][$row][1])) {
					$updWeight = 1;
				} elseif ($weight > count($this->_View->viewVars['userAttributes'][$row][1])) {
					$updWeight = count($this->_View->viewVars['userAttributes'][$row][1]) + 1;
				} else {
					$updWeight = $weight;
				}
				$onclick .= '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($updWeight) . '\'; ';
				$onclick .= $formSubmit . ';';
			}
			$output .= sprintf($moveMenuTag, $disabled, $onclick, ' glyphicon-arrow-left', __d('user_attributes', 'Go to Left'));
		}

		return $output;
	}

/**
 * 項目の移動メニューHTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	private function __moveSettingRightMenu($layout, $userAttribute) {
		$output = '';

		//データを変数にセット
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];
		$weight = (int)$userAttribute['UserAttributeSetting']['weight'];
		$row = (int)$layout['UserAttributeLayout']['id'];
		$col = (int)$userAttribute['UserAttributeSetting']['col'];

		//HTMLタグセット
		$colInputForm = 'UserAttributeSettingCol' . $userAttrSettingId;
		$weightInputForm = 'UserAttributeSettingWeight' . $userAttrSettingId;
		$formSubmit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttrSettingId . ']\')[0].submit()';
		$moveMenuTag =
			'<li%s>' .
				'<a href="" onclick="%s"> ' .
					'<span class="glyphicon%s">%s</span>' .
				'</a>' .
			'</li>';

		if ((int)$layout['UserAttributeLayout']['col'] === 2) {
			//右に移動
			if ($col === 2) {
				$disabled = ' class="disabled"';
				$onclick = '';
			} else {
				$disabled = '';
				$onclick = '$(\'#' . $colInputForm . '\')[0].value = \'' . ($col + 1) . '\'; ';
				if (! isset($this->_View->viewVars['userAttributes'][$row][2])) {
					$updWeight = 1;
				} elseif ($weight > count($this->_View->viewVars['userAttributes'][$row][2])) {
					$updWeight = count($this->_View->viewVars['userAttributes'][$row][2]) + 1;
				} else {
					$updWeight = $weight;
				}
				$onclick .= '$(\'#' . $weightInputForm . '\')[0].value = \'' . ($updWeight) . '\'; ';
				$onclick .= $formSubmit . ';';
			}
			$output .= sprintf($moveMenuTag, $disabled, $onclick, ' glyphicon-arrow-right', __d('user_attributes', 'Go to Right'));
		}

		return $output;
	}

/**
 * 項目の移動メニューHTMLを出力する
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @param array $userAttribute userAttributeデータ配列
 * @return string HTML
 */
	private function __moveSettingRowMenu($layout, $userAttribute) {
		$output = '';

		//データを変数にセット
		$userAttrSettingId = $userAttribute['UserAttributeSetting']['id'];
		$row = (int)$layout['UserAttributeLayout']['id'];

		//HTMLタグセット
		$rowInputForm = 'UserAttributeSettingRow' . $userAttrSettingId;
		$formSubmit = '$(\'form[name=' . 'UserAttributeMoveForm' . $userAttrSettingId . ']\')[0].submit()';
		$moveMenuTag =
			'<li%s>' .
				'<a href="" onclick="%s"> ' .
					'<span class="glyphicon%s">%s</span>' .
				'</a>' .
			'</li>';

		foreach ($this->_View->viewVars['userAttributeLayouts'] as $moveLayout) {
			//○段目に移動
			if ((int)$moveLayout['UserAttributeLayout']['id'] === (int)$row) {
				$disabled = ' class="disabled"';
				$onclick = '';
			} else {
				$disabled = '';
				$onclick = '$(\'#' . $rowInputForm . '\')[0].value = \'' . ($moveLayout['UserAttributeLayout']['id']) . '\'; ' . $formSubmit . ';';
			}
			$output .= sprintf($moveMenuTag, $disabled, $onclick, '', sprintf(__d('user_attributes', 'Go to %s row'), $moveLayout['UserAttributeLayout']['id']));
		}

		return $output;
	}

}
