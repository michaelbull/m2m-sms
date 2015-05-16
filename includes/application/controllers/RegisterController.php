<?php

require_once __DIR__ . '/AbstractController.php';

/**
 * Controls a 'user registration' action.
 * @author Michael
 */
final class RegisterController extends AbstractController
{
	/**
	 * Creates a new {@link RegisterController}.
	 * @param $model RegisterModel The model.
	 */
	public function __construct($model)
	{
		parent::__construct($model);
	}
	/**
	 * Checks if valid registration details have been submitted.
	 * @throws Exception If an error occurs with registration.
	 */
	public function checkValidRegistration()
	{
		if (empty($_POST['username']) && empty($_POST['password']) && empty($_POST['password2'])) {
			/* hasn't submitted any information */
			return;
		}

		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		$password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);

		$this->model->setUsername($username);

		if ($username === false) {
			$this->model->setError('Invalid username.');
		} else if (strlen($username) < 3) {
			$this->model->setError('Username requires 3 characters.');
		} else if (strlen($username) > 50) {
			$this->model->setError('Username exceeds 50 characters.');
		} else if ($password === false) {
			$this->model->setError('Invalid password.');
		} else if (strlen($password) < 3) {
			$this->model->setError('Password requires 3 characters.');
		} else if (strlen($password) > 50) {
			$this->model->setError('Password exceeds 50 characters.');
		} else if ($password !== $password2) {
			$this->model->setError('Passwords do not match.');
		} else {
			$database = new DatabaseWrapper();
			$database->connect(DB_NAME);

			try {
				/* if the queryUser method executes without any errors then it means an account does exist */
				$database->queryUser($username);
				throw new AlreadyRegisteredException();
			} catch (AlreadyRegisteredException $e) {
				throw $e; // throw the error upwards for it to be handled correctly
			} catch (Exception $e) {
				/* error thrown as the statement failed to find an account */
			}

			$database->addAccount(new UserAccount($username, password_hash($password, PASSWORD_BCRYPT), 'USER'));

			$this->model->registered();
		}
	}
}

final class AlreadyRegisteredException extends Exception
 {
	 public function __construct()
	 {
		 parent::__construct('An account has already registered with that username.');
	 }
 }
