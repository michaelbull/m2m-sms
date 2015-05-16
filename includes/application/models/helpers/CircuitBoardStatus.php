<?php

/**
 * Represents the status of a circuit board.
 * @author Michael
 */
final class CircuitBoardStatus
{
	/**
	 * The date this status was created.
	 * @var DateTime
	 */
	private $date;

	/**
	 * The status of the first switch.
	 * @var string
	 */
	private $switchOne;

	/**
	 * The status of the second switch.
	 * @var string
	 */
	private $switchTwo;

	/**
	 * The status of the third switch.
	 * @var string
	 */
	private $switchThree;

	/**
	 * The status of the fourth switch.
	 * @var string
	 */
	private $switchFour;

	/**
	 * The status of the fan.
	 * @var string
	 */
	private $fan;

	/**
	 * The current temperature of the circuit board.
	 * @var int
	 */
	private $temperature;

	/**
	 * The last entered number on the keypad.
	 * @var int
	 */
	private $keypad;

	/**
	 * Creates a new {@link CircuitBoardStatus}.
	 * @param $date DateTime The date.
	 * @param $switchOne string The status of switch one.
	 * @param $switchTwo string The status of switch two.
	 * @param $switchThree string The status of switch three.
	 * @param $switchFour string The status of switch four.
	 * @param $fan string The status of the fan.
	 * @param $temperature int The temperature.
	 * @param $keypad int The number on the keypad.
	 */
	public function __construct($date, $switchOne, $switchTwo, $switchThree, $switchFour, $fan, $temperature, $keypad)
	{
		$this->date = $date;
		$this->switchOne = $switchOne;
		$this->switchTwo = $switchTwo;
		$this->switchThree = $switchThree;
		$this->switchFour = $switchFour;
		$this->fan = $fan;
		$this->temperature = $temperature;
		$this->keypad = $keypad;
	}

	/**
	 * Creates a textual representation of this {@link CircuitBoardStatus}.
	 * @return string A textual representation of this {@link CircuitBoardStatus}.
	 */
	public function __toString()
	{
		$date = $this->getFormattedDate();

		return "Date=[$date], " .
		"Switch1=$this->switchOne, " .
		"Switch3=$this->switchThree, " .
		"Switch4=$this->switchFour, " .
		"Fan=$this->fan, " .
		"Temperature=$this->temperature, " .
		"Keypad=$this->keypad";
	}


	/**
	 * Gets the date of this status update.
	 * @return DateTime The date of this status update.
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Gets the formatted date of this status update.
	 * @return string The formatted date of this status update.
	 */
	public function getFormattedDate()
	{
		return $this->date->format(DATE_FORMAT);
	}

	/**
	 * Gets the status of switch one.
	 * @return string The status of switch one.
	 */
	public function getSwitchOne()
	{
		return $this->switchOne;
	}

	/**
	 * Gets the status of switch two.
	 * @return string The status of switch two.
	 */
	public function getSwitchTwo()
	{
		return $this->switchTwo;
	}

	/**
	 * Gets the status of switch three.
	 * @return string The status of switch three.
	 */
	public function getSwitchThree()
	{
		return $this->switchThree;
	}

	/**
	 * Gets the status of switch four.
	 * @return string The status of switch four.
	 */
	public function getSwitchFour()
	{
		return $this->switchFour;
	}

	/**
	 * Gets the status of the fan.
	 * @return string The status of the fan.
	 */
	public function getFan()
	{
		return $this->fan;
	}

	/**
	 * Gets the current temperature.
	 * @return int The current temperature.
	 */
	public function getTemperature()
	{
		return $this->temperature;
	}

	/**
	 * Gets the last number entered on the keypad.
	 * @return int The last number entered on the keypad.
	 */
	public function getKeypad()
	{
		return $this->keypad;
	}
}
