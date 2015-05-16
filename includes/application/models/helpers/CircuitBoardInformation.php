<?php

/**
 * Holds a circuit board's information.
 * @author Michael
 */
final class CircuitBoardInformation
{
	/**
	 * The MSISDN.
	 * @var string
	 */
	private $msisdn;

	/**
	 * The name of the circuit board.
	 * @var string
	 */
	private $name;

	/**
	 * Creates a new {@link CircuitBoard}.
	 * @param $msisdn int The MSISDN.
	 * @param $name string The name.
	 */
	public function __construct($msisdn, $name)
	{
		$this->msisdn = $msisdn;
		$this->name = $name;
	}

	/**
	 * Generates a string representation of this {@link CircuitBoard}.
	 * @return string A string representation of this {@link CircuitBoard}.
	 */
	public function __toString()
	{
		return "MSISDN=$this->msisdn, Name=\"$this->name\"";
	}

	/**
	 * Gets the MSISDN of this circuit board.
	 * @return int The MSISDN of this circuit board.
	 */
	public function getMSISDN()
	{
		return $this->msisdn;
	}

	/**
	 * Gets the name of this circuit board.
	 * @return string The name of this circuit board.
	 */
	public function getName()
	{
		return $this->name;
	}
}
