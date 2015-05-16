<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents a model of a logout request.
 * @author Michael
 */
final class LogoutModel extends AbstractModel
{
	/**
	 * The logged in flag.
	 * @var bool
	 */
	private $loggedIn;

	/**
	 * Creates a new {@link LogoutModel}.
	 * @param $view LogoutView The view.
	 * @param $loggedIn bool The logged in flag.
	 */
	public function __construct($view, $loggedIn)
	{
		parent::__construct($view);
		$this->loggedIn = $loggedIn;
	}

	/**
	 * Sets the logged in flag to false.
	 */
	public function loggedOut() {
		$this->loggedIn = false;
	}

	/**
	 * Checks whether the user is logged in.
	 * @return boolean {@code true} if so, {@code false} otherwise.
	 */
	public function isLoggedIn()
	{
		return $this->loggedIn;
	}
}
