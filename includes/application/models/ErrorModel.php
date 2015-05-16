<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents the data in a 'display error' action.
 * @author Michael
 */
final class ErrorModel extends AbstractModel
{
	/**
	 * The error message.
	 * @var string
	 */
	private $message;

	/**
	 * Creates a new {@link ErrorModel}.
	 * @param $view ErrorView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Sets the error message.
	 * @param $message string The message to set.
	 */
	public function setMessage($message) {
		$this->message = $message;

		$this->view->setError($message);
	}
}
