<?php 
namespace app\components\Formatter\Parsers;

/**
 * Parser Interface
 *
 * This interface describes the abilities of a parser which is able to transform
 * inputs to the object type.
 */
abstract class Parser {

	/**
	 * Constructor is used to initialize the parser
	 *
	 * @param mixed $data The input sharing a type with the parser
	 */
	abstract public function __construct($data);

	/**
	 * Retrieve a (php) array representation of the data encapsulated within Parser.
	 *
	 * @return array
	 */
	abstract public function toArray();

	/**
	 * To XML conversion
	 *
	 * @param   mixed        $data
	 * @param   null         $structure
	 * @param   null|string  $basenode
	 * @return  string
	 */
	private function xmlify($data, $structure = null, $basenode = 'xml') {

		if ($structure == null) {
			$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
		}

		// Force it to be something useful
		if (!is_array($data) && !is_object($data)) {
			$data = (array) $data;
		}

		foreach ($data as $key => $value) {
			// convert our booleans to 0/1 integer values so they are
			// not converted to blanks.
			if (is_bool($value)) {
				$value = (int) $value;
			}

			// replace anything not alpha numeric
			$key = strtoupper(preg_replace('/[^a-z_\-0-9]/i', '', $key));

			// if there is another array found recrusively call this function
			if (is_array($value) or is_object($value)) {
				$node = $structure->addChild($key);

				// recursive call if value is not empty
				if (!empty($value)) {
					$this->xmlify($value, $node, $key);
				}
			} else {
				// add single node.
				$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");

				$structure->addChild($key, $value);
			}
		}

		// pass back as string. or simple xml object if you want!
		return $structure->asXML();
	}

	/**
	 * Return an xml representation of the data stored in the parser
	 *
	 * @param string $baseNode
	 *
	 * @return string An xml string representing the encapsulated data
	 */
	public function toXml($baseNode = 'xml') {
		return $this->xmlify($this->toArray(), null, $baseNode);
	}

}
