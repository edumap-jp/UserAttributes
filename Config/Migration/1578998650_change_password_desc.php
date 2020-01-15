<?php
/**
 * パスワードの説明文修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * パスワードの説明文修正
 *
 * @property UserAttribute $UserAttribute
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Users\Config\Migration
 */
class ChangePasswordDesc extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_password_desc';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * Insert records
 *
 * @var array $migration
 */
	public $records = array(
		'UserAttribute' => array(
			//パスワード
			array('id' => '3', 'description' => '10文字以上の半角英数字、記号を入力してください。半角で英字の大文字・小文字、数字、記号の4種類すべてを1文字以上含めてください'),
			array('id' => '23', 'description' => 'Please choose at least 10 characters string. No space or special character is allowed.'),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}

		$UserAttribute = $this->generateModel('UserAttribute');
		foreach ($this->records['UserAttribute'] as $record) {
			$update = array(
				'description' => '\'' . $record['description'] . '\''
			);
			$conditions = array(
				'id' => $record['id'],
			);
			if (! $UserAttribute->updateAll($update, $conditions)) {
				return false;
			}
		}

		return true;
	}
}
