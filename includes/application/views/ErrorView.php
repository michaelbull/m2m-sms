<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * Displays any errors.
 * @author Michael
 */
final class ErrorView extends AbstractView
{
	/**
	 * Creates a new {@link ErrorView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('error', 'Error', $smarty);
	}

	/**
	 * Sets the error.
	 * @param $message string The error message.
	 */
	public function setError($message)
	{
		$this->smarty->assign('error', $message);
	}
}
