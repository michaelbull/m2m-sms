<?php

/**
 * @author Michael
 */
final class CircuitBoard
{
	/**
	 * The board's information.
	 * @var CircuitBoardInformation
	 */
	private $information;

	/**
	 * The board's new status.
	 * @var CircuitBoardStatus
	 */
	private $status;

	/**
	 * Creates a new {@link CircuitBoardUpdate}
	 * @param $information CircuitBoardInformation The board's information.
	 * @param $status CircuitBoardStatus The board's new status.
	 */
	public function __construct($information, $status)
	{
		$this->information = $information;
		$this->status = $status;
	}

	/**
	 * Gets the board's information.
	 * @return CircuitBoardInformation The board's information.
	 */
	public function getInformation()
	{
		return $this->information;
	}

	/**
	 * Gets the board's new status.
	 * @return CircuitBoardStatus The board's new status.
	 */
	public function getStatus()
	{
		return $this->status;
	}
}
