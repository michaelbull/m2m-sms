<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The registration page.
 * @author Michael
 */
final class RegisterView extends AbstractView
{
	/**
	 * Creates a new {@link RegisterView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('register', 'Register', $smarty);
	}

	/**
	 * Notifies the view a username has been entered.
	 * @param $username string The entered username.
	 */
	public function usernameEntered($username)
	{
		$this->smarty->assign('enteredUsername', $username);
	}

	/**
	 * Notifies the view that registration was unsuccessful.
	 * @param $error string The cause of failure.
	 */
	public function errorRegistering($error)
	{
		$this->smarty->assign('registerError', '<span class="menu icon-error"></span>' . $error);
	}
}
