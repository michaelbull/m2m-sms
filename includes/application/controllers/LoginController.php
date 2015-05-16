<?php

require_once __DIR__ . '/AbstractController.php';

/**
 * Controls a 'user login' action.
 * @author Michael
 */
final class LoginController extends AbstractController
{
	/**
	 * Creates a new {@link LoginController}.
	 * @param $model LoginModel The model.
	 */
	public function __construct($model)
	{
		parent::__construct($model);
	}

	/**
	 * Checks for valid login details.
	 * @throws Exception If there was an error with the login procedure.
	 */
	public function checkValidLogin()
	{
		if (empty($_POST['username']) && empty($_POST['password'])) {
			/* hasn't submitted any information */
			return;
		}

		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		$database = new DatabaseWrapper();
		$database->connect(DB_NAME);

		$account = null;
		try {
			$account = $database->queryUser($username);
		} catch (Exception $e) {
			throw new LoginDetailsException();
		}

		$passwordHash = $account->getPasswordHash();

		if (!password_verify($password, $passwordHash)) {
			throw new LoginDetailsException();
		}

		$_SESSION['username'] = $account->getUsername();
		$_SESSION['rank'] = $account->getRank();

		$this->model->loggedIn();
	}
}

final class LoginDetailsException extends Exception
{
	public function __construct()
	{
		parent::__construct('Invalid username/password. <a href="?action=login">Try again</a>.');
	}
}
