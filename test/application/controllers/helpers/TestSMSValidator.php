<?php

require_once __DIR__ . '/../../../../includes/application/controllers/helpers/SMSValidator.php';

/* normally can't store arrays as constants, however if we serialize it... */
define('VALID_SMS_MESSAGE', serialize(array(
	'SOURCEMSISDN'      => M2M_MSISDN,
	'DESTINATIONMSISDN' => M2M_MSISDN,
	'RECEIVEDTIME'      => '27/11/2014 02:19:28',
	'BEARER'            => 'SMS',
	'ID'                => SMS_IDENTIFIER,
	'S1'                => 0,
	'S2'                => 1,
	'S3'                => 0,
	'S4'                => 1,
	'F'                 => 0,
	'T'                 => 30,
	'K'                 => 5
)));

/**
 * @author Michael
 */
final class TestSMSValidator extends M2MTestCase
{
	function testValidMessage()
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$validator = new SMSValidator($message);
		$validator->validateStatus();
	}

	static function validateMSISDN($msisdn)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['SOURCEMSISDN'] = $msisdn;
		$validator = new SMSValidator($message);
		return $validator->validateMSISDN();
	}

	function testValidMSISDN()
	{
		$this->assertIdentical(447817814149, $this->validateMSISDN(447817814149));
		$this->assertIdentical(447817814149, $this->validateMSISDN('+447817814149'));
		$this->assertException('FilterException', [$this, 'validateMSISDN'], [-447817814149]);
		$this->assertIdentical(447817814149, $this->validateMSISDN('<447817814149>'));
		$this->assertIdentical(4401010101, $this->validateMSISDN(4401010101));
		$this->assertIdentical(005, $this->validateMSISDN(005));
		$this->assertIdentical(447817814149, $this->validateMSISDN('(+44) 7817 814 149'));
		$this->assertException('MissingSMSKeyException', [$this, 'validateMSISDN'], [null]);
	}

	function validateDate($date)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['RECEIVEDTIME'] = $date;

		$validator = new SMSValidator($message);
		return $validator->validateDate();
	}

	function testValidDate()
	{
		$this->assertNotNull($this->validateDate('27/12/2014 02:19:28'));
		$this->assertException('InvalidDateException', [$this, 'validateDate'], ['27/12/2014']);
		$this->assertException('InvalidDateException', [$this, 'validateDate'], ['Monday 29th Dec']);
		$this->assertNotNull($this->validateDate('1/1/2001 01:01:01'));
		$this->assertException('InvalidDateException', [$this, 'validateDate'], ['\'\'']);
		$this->assertException('InvalidDateException', [$this, 'validateDate'], ['<>\'\'#&']);
		$this->assertException('MissingSMSKeyException', [$this, 'validateDate'], [null]);
	}

	function validateBearer($bearer)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['BEARER'] = $bearer;

		$validator = new SMSValidator($message);
		return $validator->validateBearer();
	}

	function testValidBearer()
	{
		$this->assertIdentical('SMS', $this->validateBearer('SMS'));
		$this->assertException('BearerMismatchException', [$this, 'validateBearer'], ['sms']);
		$this->assertException('BearerMismatchException', [$this, 'validateBearer'], ['<sms>']);
		$this->assertException('BearerMismatchException', [$this, 'validateBearer'], ['<SMS>']);
		$this->assertException('MissingSMSKeyException', [$this, 'validateBearer'], [null]);
	}

	function validateSMSIdentifier($id)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['ID'] = $id;

		$validator = new SMSValidator($message);
		return $validator->validateSMSIdentifier();
	}

	function testValidSMSIdentifier()
	{
		$this->assertIdentical('abc123', $this->validateSMSIdentifier('abc123'));
		$this->assertException('IDMismatchException', [$this, 'validateSMSIdentifier'], ['ABC123']);
		$this->assertException('IDMismatchException', [$this, 'validateSMSIdentifier'], ['abc__123']);
		$this->assertException('IDMismatchException', [$this, 'validateSMSIdentifier'], ['#_&']);
		$this->assertException('MissingSMSKeyException', [$this, 'validateSMSIdentifier'], [null]);
	}

	function validateSwitch($state)
	{
		$switches = [1, 2, 3, 4];
		$switchNumber = $switches[array_rand($switches)]; // pick a random switch

		$message = unserialize(VALID_SMS_MESSAGE);
		$message["S$switchNumber"] = $state;

		$validator = new SMSValidator($message);
		return $validator->validateSwitch($switchNumber);
	}

	function testValidSwitch()
	{
		$this->assertIdentical('OFF', $this->validateSwitch(0));
		$this->assertIdentical('ON', $this->validateSwitch(1));
		$this->assertException('FilterException', [$this, 'validateSwitch'], ['off']);
		$this->assertException('FilterException', [$this, 'validateSwitch'], [2]);
		$this->assertException('FilterException', [$this, 'validateSwitch'], [-1]);
		$this->assertException('MissingSMSKeyException', [$this, 'validateSwitch'], [null]);
	}

	function validateFan($fan)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['F'] = $fan;

		$validator = new SMSValidator($message);
		return $validator->validateFan();
	}

	function testValidFan()
	{
		$this->assertIdentical('FORWARD', $this->validateFan(0));
		$this->assertIdentical('FORWARD', $this->validateFan('<0>'));
		$this->assertIdentical('REVERSE', $this->validateFan(1));
		$this->assertIdentical('REVERSE', $this->validateFan('1;'));
		$this->assertException('FilterException', [$this, 'validateFan'], [2]);
		$this->assertException('FilterException', [$this, 'validateFan'], [3]);
		$this->assertException('FilterException', [$this, 'validateFan'], [-1]);
		$this->assertException('FilterException', [$this, 'validateFan'], ['On']);
		$this->assertException('FilterException', [$this, 'validateFan'], ['off']);
		$this->assertException('FilterException', [$this, 'validateFan'], ['FORWARD']);
		$this->assertException('MissingSMSKeyException', [$this, 'validateFan'], [null]);
	}

	function validateTemperature($temperature)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['T'] = $temperature;

		$validator = new SMSValidator($message);
		return $validator->validateTemperature();
	}

	function testValidTemperature()
	{
		$this->assertIdentical(25, $this->validateTemperature(25));
		$this->assertIdentical(99, $this->validateTemperature(99));
		$this->assertIdentical(105, $this->validateTemperature(105));
		$this->assertIdentical(-12, $this->validateTemperature(-12));
		$this->assertException('FilterException', [$this, 'validateTemperature'], ['HOT!']);
		$this->assertException('FilterException', [$this, 'validateTemperature'], ['really cold']);
		$this->assertIdentical(-55, $this->validateTemperature(-55));
		$this->assertIdentical(-25, $this->validateTemperature(-25));
		$this->assertIdentical(25, $this->validateTemperature('SELECT 25'));
		$this->assertException('MissingSMSKeyException', [$this, 'validateTemperature'], [null]);
	}

	function validateKeypad($keypad)
	{
		$message = unserialize(VALID_SMS_MESSAGE);
		$message['K'] = $keypad;

		$validator = new SMSValidator($message);
		return $validator->validateKeypad();
	}

	function testValidKeypad()
	{
		$this->assertIdentical(0, $this->validateKeypad(0));
		$this->assertIdentical(5, $this->validateKeypad(5));
		$this->assertException('FilterException', [$this, 'validateKeypad'], [10]);
		$this->assertException('FilterException', [$this, 'validateKeypad'], [-1]);
		$this->assertException('FilterException', [$this, 'validateKeypad'], ['five']);
		$this->assertIdentical(5, $this->validateKeypad('_5'));
		$this->assertIdentical(2, $this->validateKeypad('&2&'));
		$this->assertException('MissingSMSKeyException', [$this, 'validateKeypad'], [null]);
	}
}
