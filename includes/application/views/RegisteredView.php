<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The successful registration page.
 * @author Michael
 */
final class RegisteredView extends AbstractView
{
	/**
	 * Creates a new {@link RegisteredView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('registered', 'Registered', $smarty);
	}

	/**
	 * Notifies the view a registration has been successful.
	 * @param $username string The registration username.
	 */
	public function registeredAs($username)
	{
		$this->smarty->assign('registeredUsername', $username);
	}
}
