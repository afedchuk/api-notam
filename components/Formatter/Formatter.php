<?php 
namespace app\components\Formatter;

use yii\base\InvalidParamException;
use app\components\Formatter\Parsers\ArrayParser;
use app\components\Formatter\Parsers\XmlParser;

class Formatter {
	/**
	 * Add class constants that help define input format
	 */
	const XML  = 'xml';
	const ARR  = 'array';

	private static $supportedTypes = [self::XML, self::ARR];
	private $parser;

	/**
	 * Returns an instance of formatter
	 *
	 * @param mixed $data The data that formatter should parse
	 * @param string $type The type of data formatter is expected to parse
	 *
	 * @return Formatter
	 */
	public static function make($data, $type) {
		if (in_array($type, self::$supportedTypes)) {
			$parser = null;
			switch ($type) {
				case self::ARR:
					$parser = new ArrayParser($data);
					break;
				case self::XML:
					$parser = new XmlParser($data);
					break;
			}
			return new Formatter($parser, $type);
		}
		throw new InvalidParamException(
			'make function only accepts [xml, array] for $type but ' . $type . ' was provided.'
		);
	}

	private function __construct($parser) {
		$this->parser = $parser;
	}

	public function toArray() {
		return $this->parser->toArray();
	}

	public function toXml($baseNode = 'xml') {
		return $this->parser->toXml($baseNode);
	}
}
