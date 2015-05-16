<?php

require_once __DIR__ . '/AbstractModel.php';

/**
 * Represents the data in a 'check updates' action.
 * @author Michael
 */
final class UpdatesModel extends AbstractModel
{
	/**
	 * A list of circuirt board updates.
	 * @var CircuitBoard[]
	 */
	private $updates = array();

	/**
	 * Creates a new {@link UpdatesModel}.
	 * @param $view UpdatesView The view.
	 */
	public function __construct($view)
	{
		parent::__construct($view);
	}

	/**
	 * Adds a {@link CircuitBoardUpdate}.
	 * @param $update CircuitBoard The update to add.
	 */
	public function addUpdate($update) {
		array_push($this->updates, $update);

		/* notify view of new update */
		$this->view->addUpdate($update);
	}
}
