<?php

require_once __DIR__ . '/../../models/helpers/CircuitBoardInformation.php';
require_once __DIR__ . '/../../models/helpers/CircuitBoardStatus.php';
require_once __DIR__ . '/../../models/helpers/UserAccount.php';

/**
 * Holds a database instance and provides utility methods for the database.
 * @author Michael
 */
final class DatabaseWrapper
{
	/**
	 * The database object.
	 * @var PDO
	 */
	private $database;

	/**
	 * Attempts to connect to the RDBMS.
	 * @param $database string The database to use.
	 */
	public function connect($database)
	{
		$dsn = RDBMS . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . $database;

		$options = array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // throw exceptions when encountering an error, these will be chained upwards to the error handler in Router
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		$this->database = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
	}

	/**
	 * Queries the database for board information.
	 * @return CircuitBoardInformation[] A collection of circuit board information
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws FetchStatementException If the statement fails to fetch a result.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function queryAllBoardInformation()
	{
		$statement = $this->database->prepare('SELECT * FROM board_info');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		if ($statement->execute() == false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}

		$boards = array();

		foreach ($statement as $boardInformation) {
			$msisdn = $boardInformation['msisdn'];
			$name = $boardInformation['name'];
			$information = new CircuitBoardInformation($msisdn, $name);

			array_push($boards, $information);
		}

		return $boards;
	}

	/**
	 * Queries the database for a specific board's information.
	 * @param $msisdn int The board's msisdn.
	 * @return CircuitBoardInformation The board information.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws FetchStatementException If the statement fails to fetch a result.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function queryBoardInformation($msisdn)
	{
		$statement = $this->database->prepare('SELECT * FROM board_info WHERE msisdn = :msisdn');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$statement->bindParam(':msisdn', $msisdn, PDO::PARAM_INT);

		if ($statement->execute() == false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if ($result === false) {
			throw new FetchStatementException(__FUNCTION__);
		}

		$msisdn = (int)$result['msisdn'];
		$name = $result['name'];
		$information = new CircuitBoardInformation($msisdn, $name);

		return $information;
	}

	/**
	 * Queries the database for a specific board's status.
	 * @param $msisdn int The board's msisdn.
	 * @return CircuitBoardStatus The board status.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws FetchStatementException If the statement fails to fetch a result.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function queryBoardStatus($msisdn)
	{
		$statement = $this->database->prepare('SELECT * FROM board_status WHERE msisdn = :msisdn');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$statement->bindParam(':msisdn', $msisdn, PDO::PARAM_INT);

		if ($statement->execute() == false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if ($result === false) {
			throw new FetchStatementException(__FUNCTION__);
		}

		$date = DateTime::createFromFormat(DB_DATE_FORMAT, $result['date']);
		$switchOne = $result['switchOne'];
		$switchTwo = $result['switchTwo'];
		$switchThree = $result['switchThree'];
		$switchFour = $result['switchFour'];
		$fan = $result['fan'];
		$temperature = (int)$result['temperature'];
		$keypad = (int)$result['keypad'];

		$status = new CircuitBoardStatus($date,
			$switchOne, $switchTwo, $switchThree, $switchFour,
			$fan, $temperature, $keypad);

		return $status;
	}

	/**
	 * Queries the {@var $database} for a user account.
	 * @param $username string The account's username.
	 * @return UserAccount The user account.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws FetchStatementException If the statement fails to fetch a result.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function queryUser($username)
	{
		$statement = $this->database->prepare('SELECT * FROM users WHERE username = :username');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$statement->bindParam(':username', $username, PDO::PARAM_STR);

		if ($statement->execute() == false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if ($result === false) {
			throw new FetchStatementException(__FUNCTION__);
		}

		$username = $result['username'];
		$passwordHash = $result['passwordHash'];
		$rank = $result['rank'];

		return new UserAccount($username, $passwordHash, $rank);
	}

	/**
	 * Updates the {@var database} with the status of a circuit board.
	 * @param $msisdn int The msisdn of the circuit board.
	 * @param $status CircuitBoardStatus The circuit board's status.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function updateBoardStatus($msisdn, $status)
	{
		$date = $status->getDate()->format(DB_DATE_FORMAT);
		$switchOne = $status->getSwitchOne();
		$switchTwo = $status->getSwitchTwo();
		$switchThree = $status->getSwitchThree();
		$switchFour = $status->getSwitchFour();
		$fan = $status->getFan();
		$temperature = $status->getTemperature();
		$keypad = $status->getKeypad();

		/*
		 * 'REPLACE INTO' will create the row if it does not exist
		 * or update the values in it if it does
		 */
		$statement = $this->database->prepare(
			'REPLACE INTO board_status
			SET msisdn = :msisdn,
			date = :date,
			switchOne = :switchOne,
			switchTwo = :switchTwo,
			switchThree = :switchThree,
			switchFour = :switchFour,
			fan = :fan,
			temperature = :temperature,
			keypad = :keypad');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$statement->bindParam(':msisdn', $msisdn, PDO::PARAM_STR);
		$statement->bindParam(':date', $date, PDO::PARAM_STR);
		$statement->bindParam(':switchOne', $switchOne, PDO::PARAM_STR);
		$statement->bindParam(':switchTwo', $switchTwo, PDO::PARAM_STR);
		$statement->bindParam(':switchThree', $switchThree, PDO::PARAM_STR);
		$statement->bindParam(':switchFour', $switchFour, PDO::PARAM_STR);
		$statement->bindParam(':fan', $fan, PDO::PARAM_STR);
		$statement->bindParam(':temperature', $temperature, PDO::PARAM_INT);
		$statement->bindParam(':keypad', $keypad, PDO::PARAM_INT);

		if ($statement->execute() === false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}
	}

	/**
	 * Updates the {@var database} with a new user account.
	 * @param $account UserAccount The user account.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function addAccount($account)
	{
		$statement = $this->database->prepare(
			'INSERT INTO users
			SET username = :username,
			passwordHash = :passwordHash,
			rank = :rank');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$username = $account->getUsername();
		$passwordHash = $account->getPasswordHash();
		$rank = $account->getRank();

		$statement->bindParam(':username', $username, PDO::PARAM_STR);
		$statement->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
		$statement->bindParam(':rank', $rank, PDO::PARAM_STR);

		if ($statement->execute() === false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}
	}

	/**
	 * Deletes a user account from the the {@var database}.
	 * @param $username string The username.
	 * @throws ExecuteStatementException If the statement fails to execute.
	 * @throws PrepareStatementException If the statement fails to prepare.
	 */
	public function deleteUser($username)
	{
		$statement = $this->database->prepare(
			'DELETE FROM users
			WHERE username = :username');

		if ($statement === false) {
			throw new PrepareStatementException(__FUNCTION__);
		}

		$statement->bindParam(':username', $username, PDO::PARAM_STR);

		if ($statement->execute() === false) {
			throw new ExecuteStatementException(__FUNCTION__);
		}
	}
}

class DatabaseException extends Exception
{
	/**
	 * Creates a new database exception.
	 * @param $action string The database action being performed.
	 * @param $function string The function name.
	 */
	public function __construct($action, $function)
	{
		parent::__construct("[$function] Failed to $action statement.");
	}
}

final class PrepareStatementException extends DatabaseException
{
	/**
	 * Creates a new prepare statement exception.
	 * @param $function string The function name.
	 */
	public function __construct($function)
	{
		parent::__construct('prepare', $function);
	}
}

final class ExecuteStatementException extends DatabaseException
{
	/**
	 * Creates a new execute statement exception.
	 * @param $function string The function name.
	 */
	public function __construct($function)
	{
		parent::__construct('execute', $function);
	}
}

final class FetchStatementException extends DatabaseException
{
	/**
	 * Creates a new fetch statement exception.
	 * @param $function string The function name.
	 */
	public function __construct($function)
	{
		parent::__construct('fetch', $function);
	}
}
