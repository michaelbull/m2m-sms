<?php

require_once __DIR__ . '/../../../../includes/application/controllers/helpers/XMLParser.php';

define('VALID_XML_MESSAGE',
	"<messagerx>" .
	"<sourcemsisdn>447817814149</sourcemsisdn>" .
	"<destinationmsisdn>447817814149</destinationmsisdn>" .
	"<receivedtime>27/12/2014 02:19:28</receivedtime>" .
	"<bearer>SMS</bearer>" .
	"<messageref>0</messageref>" .
	"<message>" .
	"<id>abc123</id>" .
	"<s1>0</s1>" .
	"<s2>1</s2>" .
	"<s3>0</s3>" .
	"<s4>1</s4>" .
	"<f>0</f>" .
	"<t>38</t>" .
	"<k>5</k>" .
	"</message>" .
	"</messagerx>"
);

/**
 * @author Michael
 */
final class TestXMLParser extends M2MTestCase
{
	function testParse()
	{
		$parser = new XMLParser(VALID_XML_MESSAGE);
		$parser->parse();
		$this->assertFalse(sizeof($parser->getParsedData()) == 0);
	}
}
