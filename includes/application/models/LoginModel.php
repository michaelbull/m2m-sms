<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents a model of a login request.
 * @author Michael
 */
final class LoginModel extends AbstractModel
{
	/**
	 * A flag indicating whether we have logged in.
	 * @var bool
	 */
	private $loggedIn = false;

	/**
	 * Creates a new {@link LoginModel}.
	 * @param $view LoginView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Gets the logged in flag.
	 * @return bool {@code true} if so, {@code false} otherwise.
	 */
	public function isLoggedIn()
	{
		return $this->loggedIn;
	}

	/**
	 * Sets the logged in flag to true.
	 */
	public function loggedIn()
	{
		$this->loggedIn = true;
	}
}
