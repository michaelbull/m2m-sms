<?php


/**
 * Holds a SOAP client instance and provides utility methods for communicating to the SOAP server.
 * @author Michael
 */
final class SoapClientWrapper
{
	/**
	 * The SOAP client.
	 * @var SoapClient
	 */
	private $client;

	/**
	 * Creates a new {@link SoapClientWrapper}.
	 */
	public function __construct()
	{
		$this->client = new SoapClient(WSDL_URI);
	}

	/**
	 * Polls the SOAP client for new messages.
	 * @return string[] An array of new messages.
	 */
	public function getNewMessages()
	{
		return $this->client->peekMessages(M2M_USERNAME, M2M_PASSWORD, 15);
	}
}
