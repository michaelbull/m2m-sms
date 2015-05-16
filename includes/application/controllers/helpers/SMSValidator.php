<?php

/**
 * Validates raw XML formatted SMS messages.
 * @author Michael
 */
final class SMSValidator
{
	/**
	 * The message to validate.
	 * @var array
	 */
	private $message;

	/**
	 * Creates a new {@link SMSValidator}
	 * @param $message array The message to validate
	 */
	public function __construct($message)
	{
		$this->message = $message;
	}

	/**
	 * Gets the value of a field in this message.
	 * @param $key string The field's key.
	 * @return mixed The value
	 * @throws Exception If the key is missing.
	 */
	private function getValue($key)
	{
		if (!isset($this->message[$key])) {
			throw new MissingSMSKeyException($key);
		}

		return $this->message[$key];
	}

	/**
	 * Validates the 'SOURCEMSISDN' field.
	 * @return string The validated field.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateMSISDN()
	{
		$key = 'SOURCEMSISDN';

		$msisdn = $this->getValue($key);
		$msisdn = filter_var($msisdn, FILTER_SANITIZE_NUMBER_INT);
		$msisdn = filter_var($msisdn, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 999999999999999))); // at minimum 1 digit, at maximum 15 digits

		if ($msisdn === false) {
			throw new FilterException($key);
		}

		return (int)$msisdn;
	}

	/**
	 * Validates the received date value.
	 * @return DateTime The validated date object.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateDate()
	{
		$key = 'RECEIVEDTIME';

		$receivedTime = $this->getValue($key);
		$receivedTime = filter_var($receivedTime, FILTER_SANITIZE_STRING);

		if ($receivedTime === false) {
			throw new FilterException($key);
		}

		$date = DateTime::createFromFormat(DATE_FORMAT, $receivedTime);

		if ($date === false) {
			throw new InvalidDateException($key);
		}

		return $date;
	}

	/**
	 * Validates the bearer field.
	 * @return string The bearer field.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateBearer()
	{
		$key = 'BEARER';

		$bearer = $this->getValue($key);
		$bearer = filter_var($bearer, FILTER_SANITIZE_STRING);

		if ($bearer === false) {
			throw new FilterException($key);
		}

		if ($bearer !== 'SMS') {
			throw new BearerMismatchException($key);
		}

		return $bearer;
	}

	/**
	 * Validates the SMS identifier.
	 * @return string The SMS identifier.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateSMSIdentifier()
	{
		$key = 'ID';

		$smsIdentifier = $this->getValue($key);
		$smsIdentifier = filter_var($smsIdentifier, FILTER_SANITIZE_STRING);

		if ($smsIdentifier === false) {
			throw new FilterException($key);
		}

		if ($smsIdentifier !== SMS_IDENTIFIER) {
			throw new IDMismatchException($key);
		}

		return $smsIdentifier;
	}

	/**
	 * Sanitizes and validates a switch status.
	 * @param $switchNumber int The switch number to validate.
	 * @return string The switch status.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateSwitch($switchNumber)
	{
		$key = 'S' . $switchNumber;

		if ($switchNumber < 1 || $switchNumber > 4) {
			throw new InvalidSwitchException($key);
		}

		$switch = $this->getValue($key);
		$switch = filter_var($switch, FILTER_SANITIZE_NUMBER_INT);
		$switch = filter_var($switch, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 1)));

		if ($switch === false) {
			throw new FilterException($key);
		}

		if ($switch === 0) {
			return 'OFF';
		} else if ($switch === 1) {
			return 'ON';
		}

		throw new SwitchStateMismatchException($key);
	}

	/**
	 * Sanitizes and validates the fan status.
	 * @return string The fan status.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateFan()
	{
		$key = 'F';

		$fan = $this->getValue($key);
		$fan = filter_var($fan, FILTER_SANITIZE_NUMBER_INT);
		$fan = filter_var($fan, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 1)));

		if ($fan === false) {
			throw new FilterException($key);
		}

		if ($fan === 0) {
			return 'FORWARD';
		} else if ($fan === 1) {
			return 'REVERSE';
		}

		throw new FanStateMismatchException($key);
	}

	/**
	 * Sanitizes and validates a temperature amount.
	 * @return string The validated temperature.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateTemperature()
	{
		$key = 'T';

		$temperature = $this->getValue($key);
		$temperature = filter_var($temperature, FILTER_SANITIZE_NUMBER_INT);
		$temperature = filter_var($temperature, FILTER_VALIDATE_INT, array('options' => array('min_range' => -99, 'max_range' => 999))); // 3 max digits at all times

		if ($temperature === false) {
			throw new FilterException($key);
		}

		return (int)$temperature;
	}

	/**
	 * Sanitizes and validates the keypad input.
	 * @return string The validated keypad input.
	 * @throws Exception If an error occurs during sanitisation/validation.
	 */
	public function validateKeypad()
	{
		$key = 'K';

		$keypad = $this->getValue($key);
		$keypad = filter_var($keypad, FILTER_SANITIZE_NUMBER_INT);
		$keypad = filter_var($keypad, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0, 'max_range' => 9))); // must be 1 digit

		if ($keypad === false) {
			throw new FilterException($key);
		}

		return (int)$keypad;
	}

	/**
	 * Sanitizes and validates the {@var $message} into a {@link CircuitBoardStatus}.
	 * @return CircuitBoardStatus The validated circuit board status or {@code null} if the message did not contain a valid circuit board status..
	 */
	public function validateStatus()
	{
		$date = $this->validateDate();
		$this->validateBearer();
		$switchOne = $this->validateSwitch(1);
		$switchTwo = $this->validateSwitch(2);
		$switchThree = $this->validateSwitch(3);
		$switchFour = $this->validateSwitch(4);
		$fan = $this->validateFan();
		$temperature = $this->validateTemperature();
		$keypad = $this->validateKeypad();

		$status = new CircuitBoardStatus($date,
			$switchOne, $switchTwo, $switchThree, $switchFour,
			$fan, $temperature, $keypad);

		return $status;
	}
}

final class MissingSMSKeyException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("Missing value for $key.");
	}
}

final class FilterException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Filter failed.");
	}
}

final class InvalidDateException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Must be in format of " . DATE_FORMAT . ".");
	}
}

final class BearerMismatchException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Must be SMS.");
	}
}

final class IDMismatchException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Must match " . SMS_IDENTIFIER . ".");
	}
}

final class InvalidSwitchException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Switch number must be 1-4 inclusive.");
	}
}

final class SwitchStateMismatchException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Must be either 0 (OFF) or 1 (ON).");
	}
}

final class FanStateMismatchException extends Exception
{
	public function __construct($key)
	{
		parent::__construct("$key Must be either 0 (FORWARD) or 1 (REVERSE).");
	}
}
