<?php

require_once __DIR__ . '/../models/helpers/CircuitBoard.php';
require_once __DIR__ . '/helpers/DatabaseWrapper.php';
require_once __DIR__ . '/helpers/SMSValidator.php';
require_once __DIR__ . '/helpers/SoapClientWrapper.php';
require_once __DIR__ . '/helpers/XMLParser.php';
require_once __DIR__ . '/AbstractController.php';

/**
 * Controls a 'check updates' action.
 * @author Michael
 */
final class UpdatesController extends AbstractController
{
	/**
	 * Creates a new {@link StatusesController}.
	 * @param $model UpdatesModel The model.
	 */
	public function __construct($model)
	{
		parent::__construct($model);
	}

	/**
	 * Fetches the statuses of the circuit boards from the database.
	 * @throws Exception If a query fails to execute.
	 */
	public function fetchUpdates() {
		$soap = new SoapClientWrapper();
		$messages = $soap->getNewMessages();

		$database = new DatabaseWrapper();
		$database->connect(DB_NAME);

		foreach ($messages as $message) {
			$xmlParser = new XMLParser($message);
			$xmlParser->parse();
			$parsedMessage = $xmlParser->getParsedData();

			$validator = new SMSValidator($parsedMessage);

			try {
				$msisdn = $validator->validateMSISDN();
				$status = $validator->validateStatus();

				$information = $database->queryBoardInformation($msisdn);

				$update = new CircuitBoard($information, $status);

				$database->updateBoardStatus($msisdn, $status);

				$this->model->addUpdate($update);
			} catch (Exception $e) {
				continue;
			}
		}
	}
}
