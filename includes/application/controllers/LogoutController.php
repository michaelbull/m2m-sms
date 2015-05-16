<?php

require_once __DIR__ . '/AbstractController.php';

/**
 * Controls a 'user logout' action.
 * @author Michael
 */
final class LogoutController extends AbstractController
{
	/**
	 * Creates a new {@link LogoutController}.
	 * @param $model LogoutModel The model.
	 */
	public function __construct($model)
	{
		parent::__construct($model);
	}

	/**
	 * Logs a user out.
	 * @throws Exception If logout fails.
	 */
	public function logout()
	{
		if (!$this->model->isLoggedIn()) {
			throw new LoggedOutException;
		}

		if (!session_destroy()) {
			throw new DestroySessionException;
		}

		unset($_SESSION['username']);
		unset($_SESSION['rank']);
	}
}

final class LoggedOutException extends Exception
{
	public function __construct()
	{
		parent::__construct('Already logged out.');
	}
}

final class DestroySessionException extends Exception
{
	public function __construct()
	{
		parent::__construct('Failed to destroy session.');
	}
}
