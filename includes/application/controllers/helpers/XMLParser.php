<?php

/**
 * Used to parse a raw XML string into an array of key->value pairs.
 * @author Michael
 */
final class XMLParser
{
	/**
	 * The xml parser resource.
	 * @var resource
	 */
	private $xmlParser;

	/**
	 * The raw string to parse.
	 * @var string
	 */
	private $contentToParse;

	/**
	 * The currently entered element name.
	 * @var string
	 */
	private $currentElementName;

	/**
	 * The temporarily stored attributes.
	 * @var array
	 */
	private $temporaryAttributes;

	/**
	 * The parsed XML data.
	 * @var array
	 */
	private $parsedData = array();

	/**
	 * Creates a new {@link XMLParser}.
	 * @param $contentToParse string The content to parse.
	 */
	public function __construct($contentToParse)
	{
		$this->xmlParser = xml_parser_create();
		$this->contentToParse = $contentToParse;
	}

	/**
	 * Releases the retained memory for this {@link XMLParser}.
	 */
	public function __destruct()
	{
		xml_parser_free($this->xmlParser);
	}

	/**
	 * Parses an XML file.
	 */
	public function parse()
	{
		// allow the parser to operate within an object
		xml_set_object($this->xmlParser, $this);

		// assign functions to be called when a new element is started and ended
		xml_set_element_handler($this->xmlParser, "startElementHandler", "endElementHandler");

		// assign the function to be used when an element contains data
		xml_set_character_data_handler($this->xmlParser, "processElementData");

		xml_parse($this->xmlParser, $this->contentToParse);
	}

	/**
	 * Processes an open element, stores the tag name and extracts the attribute names and values.
	 * @param $parser object The XML parser instance.
	 * @param $elementName string The element name.
	 * @param $attributes array The attributes.
	 */
	private function startElementHandler($parser, $elementName, $attributes)
	{
		$this->currentElementName = $elementName;
		if (sizeof($attributes) > 0) {
			foreach ($attributes as $attributeName => $attributeValue) {
				$tagAttribute = $elementName . "." . $attributeName;
				$this->temporaryAttributes[$tagAttribute] = $attributeValue;
			}
		}
	}

	/**
	 * Process the data within the element.
	 * @param $parser object The XML parser instance.
	 * @param $elementData array The data within the element.
	 */
	private function processElementData($parser, $elementData)
	{
		$this->parsedData[$this->currentElementName] = $elementData;

		if (sizeof($this->temporaryAttributes) > 0) {
			foreach ($this->temporaryAttributes as $name => $value) {
				$this->parsedData[$name] = $value;
			}
		}
	}

	/**
	 * Closes an open element.
	 * @param $parser object The XML parser instance.
	 * @param $elementName string The element name.
	 */
	private function endElementHandler($parser, $elementName)
	{
		/* empty */
	}

	/**
	 * Gets the parsed XML data.
	 * @return array The parsed XML data.
	 */
	public function getParsedData()
	{
		return $this->parsedData;
	}
}
