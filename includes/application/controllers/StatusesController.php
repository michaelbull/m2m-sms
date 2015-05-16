<?php

require_once __DIR__ . '/helpers/DatabaseWrapper.php';
require_once __DIR__ . '/AbstractController.php';

/**
 * Controls a 'view statuses' action.
 * @author Michael
 */
final class StatusesController extends AbstractController
{
	/**
	 * Creates a new {@link StatusesController}.
	 * @param $model StatusesModel The model.
	 */
	public function __construct($model)
	{
		parent::__construct($model);
	}

	/**
	 * Fetches the statuses of the circuit boards from the database.
	 * @throws Exception If a query fails to execute.
	 */
	public function fetchStatuses() {
		$database = new DatabaseWrapper();
		$database->connect(DB_NAME);

		$boards = $database->queryAllBoardInformation();

		foreach($boards as $board) {
			$msisdn = $board->getMSISDN();
			$status = null;

			try {
				$status = $database->queryBoardStatus($msisdn);
			} catch (Exception $e) {
				/* failed to find its status */
			}

			$this->model->addBoard(new CircuitBoard($board, $status));
		}
	}
}
