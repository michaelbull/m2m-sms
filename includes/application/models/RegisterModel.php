<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents the data in a registration request.
 * @author Michael
 */
final class RegisterModel extends AbstractModel
{
	/**
	 * The entered username.
	 * @var string
	 */
	private $username;

	/**
	 * The registered flag.
	 * @var bool
	 */
	private $registered = false;

	/**
	 * The error.
	 * @var string
	 */
	private $error = '';

	/**
	 * Creates a new {@link RegisterModel}.
	 * @param $view RegisterView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Gets the entered username.
	 * @return string The entered username.
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Sets the entered username.
	 * @param $username string The username to set.
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		$this->view->usernameEntered($this->username);
	}

	/**
	 * Checks whether the registration was successful.
	 * @return bool {@code true} if so, {@code false} otherwise.
	 */
	public function isRegistered()
	{
		return $this->registered;
	}

	/**
	 * Called when a registration was successful.
	 */
	public function registered()
	{
		$this->registered = true;
	}

	/**
	 * Gets the registration error.
	 * @return string The registration error.
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Sets the registration error.
	 * @param $error string The registration error to set.
	 */
	public function setError($error)
	{
		$this->error = $error;

		$this->view->errorRegistering($error);
	}
}
