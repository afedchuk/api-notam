<?php
namespace tests\codeception\unit\components\Formatter\Parsers;

use app\components\Formatter\Parsers\Parser;
use app\components\Formatter\Parsers\XmlParser;

class XmlParserTest extends \Codeception\TestCase\Test
{
    public function testXmlParserIsInstanceOfParserInterface() {
        $parser = new XmlParser('');
        $this->assertTrue($parser instanceof Parser);
    }
    public function testToArrayReturnsArrayRepresenationOfXmlObject() {
        $expected = ['foo' => 'bar'];
        $parser = new XmlParser('<xml><foo>bar</foo></xml>');
        $this->assertEquals($expected, $parser->toArray());
    }
}