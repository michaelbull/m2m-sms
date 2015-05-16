<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents a model of a successful registration.
 * @author Michael
 */
final class RegisteredModel extends AbstractModel
{
	/**
	 * The username we registered with.
	 * @var string
	 */
	private $username;

	/**
	 * Creates a new {@link RegisteredModel}.
	 * @param $view RegisteredView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Sets the username we are registered with.
	 * @param $username string The username to set.
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		/* notify the view we registered an account */
		$this->view->registeredAs($username);
	}

	/**
	 * Gets the username we registered with.
	 * @return string The username we registered with.
	 */
	public function getUsername()
	{
		return $this->username;
	}
}
