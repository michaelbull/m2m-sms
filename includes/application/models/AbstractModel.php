<?php

/**
 * Represents a 'Model' in the MVC pattern.
 * @author Michael
 */
abstract class AbstractModel
{
	/**
	 * The view.
	 * @var AbstractView
	 */
	protected $view;

	/**
	 * Creates a new {@link AbstractModel}.
	 * @param $view AbstractView The view.
	 */
	protected function __construct($view)
	{
		$this->view = $view;
	}
}