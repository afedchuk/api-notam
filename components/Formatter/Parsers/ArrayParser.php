<?php 
namespace app\components\Formatter\Parsers;

use yii\base\InvalidArgumentException;

class ArrayParser extends Parser {
	private $array;

	/**
    * Converting data into an array
    **/
	public function __construct($data) {
		if (is_string($data)) {
			$data = unserialize($data);
		}
		if (is_array($data) || is_object($data)) {
			if(($data instanceof \SimpleXMLElement) === true) {
				$xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
            	$this->array = json_decode(json_encode($xml), TRUE);
			} else {
				$this->array = (array) $data;
			}			
		} else {
			throw new InvalidArgumentException(
				'ArrayParser only accepts (optionally serialized) [object, array] for $data.'
			);
		}
	}

	public function toArray() {
		return $this->array;
	}
}