<?php
/**
 * UserAttributeBehaviorTransactionTest test case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * UserAttributeBehaviorTransactionTest
 */
class UserAttributeBehaviorTransactionTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.user_attributes.user_attribute',
		'plugin.user_attributes.user_attribute_setting',
		'plugin.users.user',
		'plugin.users.users_language',
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		$this->fixtureManager->shutDown();
	}

/**
 * Test rollback after alter table
 *
 * alter table で暗黙的なコミットが発生するため、rollbackしても戻らない。
 * [https://dev.mysql.com/doc/refman/5.6/ja/implicit-commit.html]
 */
	public function testAlterTableSuccessAndRollback() {
		$userAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
		$data = array(
				'name' => 'Rollback test',
				$userAttribute->UserAttributeSetting->alias => array(
						'user_attribute_key' => 'rollback_test_key',
						'data_type_key' => 'rollback_test_key'
				)
		);

		$userAttribute->begin();
		$userAttribute->save($data, false);

		$userAttribute->addColumnByUserAttribute($data);
		$userAttribute->rollback();

		$userAttribute->recursive = -1;
		$this->assertEquals(2, $userAttribute->find('count'));

		$fields = $userAttribute->User->schema(true);
		$this->assertArrayHasKey('rollback_test_key', $fields);
	}

/**
 * Test alter table error and rollback
 */
	public function testAlterTableErrorAndRollback() {
		$userAttribute = ClassRegistry::init('UserAttributes.UserAttribute');
		$data = array(
			'name' => 'Rollback test',
			$userAttribute->UserAttributeSetting->alias => array(
				'user_attribute_key' => 'rollback_test_key',
				'data_type_key' => 'rollback_test_key'
			)
		);

		$cakeMigrationMock = $this->getMock(
			'CakeMigration',
			['before'],
			[['connection' => $userAttribute->useDbConfig]]
		);
		$cakeMigrationMock
			->expects($this->once())
			->method('before')
			->will($this->throwException(new Exception));
		$userAttribute->Behaviors->UserAttribute->cakeMigration = $cakeMigrationMock;

		$userAttribute->begin();
		$userAttribute->save($data, false);
		try {
			$userAttribute->addColumnByUserAttribute($data);
		}
		catch (Exception $expected) {
			$userAttribute->rollback();
			$userAttribute->recursive = -1;
			$this->assertEquals(1, $userAttribute->find('count'));

			$fields = $userAttribute->User->schema(true);
			$this->assertArrayNotHasKey('rollback_test_key', $fields);

			return;
		}

		$this->fail();
	}
}