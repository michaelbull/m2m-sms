<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The successful login page.
 * @author Michael
 */
final class LoggedInView extends AbstractView
{
	/**
	 * Creates a new {@link LoggedInView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('loggedin', 'Logged In', $smarty);
	}

	/**
	 * Called when the model successfully logs into an account.
	 * @param $username string The username of the account we have logged in to.
	 */
	public function loggedInTo($username) {
		$this->smarty->assign('loggedInTo', $username);
	}
}
