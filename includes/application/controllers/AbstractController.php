<?php

/**
 * Represents a 'Controller' in the MVC pattern.
 * @author Michael
 */
abstract class AbstractController
{
	/**
	 * The model.
	 * @var AbstractModel
	 */
	protected $model;

	/**
	 * Creates a new {@link AbstractModel}.
	 * @param $model AbstractModel The model.
	 */
	protected function __construct($model)
	{
		$this->model = $model;
	}
}
