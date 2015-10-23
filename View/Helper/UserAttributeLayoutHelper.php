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
 * 会員項目のレイアウトで使用するヘルパー
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\UserAttribute\View\Helper
 */
class UserAttributeLayoutHelper extends AppHelper {

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
 * 会員項目レイアウトのHTMLを出力する(段目)
 *
 * @return string HTML
 */
	public function renderRow($elementFile) {
		$output = '';

		foreach ($this->_View->viewVars['userAttributeLayouts'] as $layout) {
			$output .= $this->_View->element($elementFile, array(
				'layout' => $layout,
			));
		}
		return $output;
	}

/**
 * 会員項目レイアウトのHTMLを出力する(列)
 *
 * @param array $layout userAttributeLayoutデータ配列
 * @return string HTML
 */
	public function renderCol($elementFile, $layout) {
		$output = '';

		$row = $layout['UserAttributeLayout']['id'];
		for ($col = 1; $col <= UserAttributeLayout::LAYOUT_COL_NUMBER; $col++) {
			if ($layout['UserAttributeLayout']['col'] === '2' &&
					! isset($this->_View->viewVars['userAttributes'][$row][1]) &&
					isset($this->_View->viewVars['userAttributes'][$row][2])) {
				$output .= '<div class="col-xs-12 col-sm-offset-6 col-sm-6">';
			} else {
				$output .= '<div class="col-xs-12 col-sm-' . (12 / $layout['UserAttributeLayout']['col']) . '">';
			}

			if (isset($this->_View->viewVars['userAttributes'][$row][$col])) {
				foreach ($this->_View->viewVars['userAttributes'][$row][$col] as $userAttribute) {
					$output .= $this->_View->element($elementFile, array(
						'layout' => $layout,
						'userAttribute' => $userAttribute
					));
				}
			}

			$output .= '</div>';
		}
		return $output;
	}

}
