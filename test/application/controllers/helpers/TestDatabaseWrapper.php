<?php

require_once __DIR__ . '/../../../../includes/application/controllers/helpers/DatabaseWrapper.php';

/**
 * @author Michael
 */
final class TestDatabaseWrapper extends M2MTestCase
{
	/**
	 * @var DatabaseWrapper
	 */
	private $db;

	function setUp()
	{
		$this->db = new DatabaseWrapper();
		$this->db->connect(TEST_DB_NAME);
	}

	function testQueryAllBoardInformation()
	{
		$result = $this->db->queryAllBoardInformation();
		$this->assertTrue(count($result) == 2);
	}

	function testQueryBoardInformation()
	{
		$expected = new CircuitBoardInformation(12345, 'testboard');
		$result = $this->db->queryBoardInformation(12345);
		$this->assertIdentical($expected, $result);

		$this->assertException('FetchStatementException', [$this->db, 'queryBoardInformation'], [1122]);
	}

	function testQueryBoardStatus()
	{
		$expected = new CircuitBoardStatus(new DateTime('2015-01-07 18:47:17.000000'), 'ON', 'ON', 'ON', 'ON', 'FORWARD', 12, 3);
		$result = $this->db->queryBoardStatus(12345);

		// for some reason DateTime identical assertions never match?

		$this->assertIdentical($expected->getSwitchOne(), $result->getSwitchOne());
		$this->assertIdentical($expected->getSwitchTwo(), $result->getSwitchTwo());
		$this->assertIdentical($expected->getSwitchThree(), $result->getSwitchThree());
		$this->assertIdentical($expected->getSwitchFour(), $result->getSwitchFour());
		$this->assertIdentical($expected->getFan(), $result->getFan());
		$this->assertIdentical($expected->getTemperature(), $result->getTemperature());
		$this->assertIdentical($expected->getKeypad(), $result->getKeypad());

		$this->assertException('FetchStatementException', [$this->db, 'queryBoardStatus'], [1122]);
	}

	function testQueryUser()
	{
		$expected = new UserAccount('test', '$2y$10$XQCPxvGTXsqdKY4/h831A.Y9NjizXLPM7uQkM/OkLEdFXHSItLKsO', 'USER');
		$result = $this->db->queryUser('test');
		$this->assertIdentical($expected, $result);

		$this->assertException('FetchStatementException', [$this->db, 'queryUser'], ['nobody']);
	}

	function randomCircuitBoardStatus()
	{
		$switchStates = array('OFF', 'ON');
		$fanStates = array('FORWARD', 'REVERSE');

		return new CircuitBoardStatus(new DateTime(),
			$switchStates[array_rand($switchStates)], $switchStates[array_rand($switchStates)], $switchStates[array_rand($switchStates)], $switchStates[array_rand($switchStates)],
			$fanStates[array_rand($fanStates)], rand(0, 99), rand(0, 9));
	}

	function testUpdateBoardStatus()
	{
		for ($i = 0; $i < 10; $i++) { /* as we use random data lets perform this test a few times */
			$expected = $this->randomCircuitBoardStatus();
			$this->db->updateBoardStatus(6789, $expected);
			$result = $this->db->queryBoardStatus(6789);

			$this->assertIdentical($expected->getSwitchOne(), $result->getSwitchOne());
			$this->assertIdentical($expected->getSwitchTwo(), $result->getSwitchTwo());
			$this->assertIdentical($expected->getSwitchThree(), $result->getSwitchThree());
			$this->assertIdentical($expected->getSwitchFour(), $result->getSwitchFour());
			$this->assertIdentical($expected->getFan(), $result->getFan());
			$this->assertIdentical($expected->getTemperature(), $result->getTemperature());
			$this->assertIdentical($expected->getKeypad(), $result->getKeypad());
		}
	}

	function testAddDeleteAccount()
	{
		$expected = new UserAccount('new_acc', 'pass', 'ADMIN');
		$this->db->addAccount($expected);
		$result = $this->db->queryUser('new_acc');
		$this->db->deleteUser('new_acc'); // clean up after ourselves
		$this->assertIdentical($expected, $result);
	}
}
