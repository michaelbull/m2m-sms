<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents a model of a successful login.
 * @author Michael
 */
final class LoggedInModel extends AbstractModel
{
	/**
	 * The username we are logged in to.
	 * @var string
	 */
	private $username;

	/**
	 * Creates a new {@link LoggedInModel}.
	 * @param $view LoggedInView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Sets the username we are logged in to.
	 * @param $username string The username to set.
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		/* notify the view we have logged into an account */
		$this->view->loggedInTo($username);
	}
}
