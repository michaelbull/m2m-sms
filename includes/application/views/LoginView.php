<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The login page.
 * @author Michael
 */
final class LoginView extends AbstractView
{
	/**
	 * Creates a new {@link LoginView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('login', 'Login', $smarty);
	}
}
