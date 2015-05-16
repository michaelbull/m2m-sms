<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The logout page.
 * @author Michael
 */
final class LogoutView extends AbstractView
{
	/**
	 * Creates a new {@link LogoutView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('logout', 'Logged Out', $smarty);
	}
}
