<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents the data in a 'view statuses' action.
 * @author Michael
 */
final class StatusesModel extends AbstractModel
{
	/**
	 * A collection of {@link CircuitBoard}s.
	 * @var CircuitBoard[]
	 */
	private $boards = array();

	/**
	 * Creates a new {@link StatusesModel}.
	 * @param $view StatusesView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Adds a circuit board to the model.
	 * @param $board CircuitBoard The circuit board.
	 */
	public function addBoard($board) {
		array_push($this->boards, $board);

		$this->view->addBoard($board);
	}
}
