<?php
namespace tests\codeception\unit\components\Formatter\Parsers;

use stdClass;
use app\components\Formatter\Parsers\Parser;
use app\components\Formatter\Parsers\ArrayParser;


class ArrayParserTest extends \Codeception\TestCase\Test
{
    public function testArrayParserIsInstanceOfParserInterface() {
        $parser = new ArrayParser(new \stdClass);
        $this->assertTrue($parser instanceof Parser);
    }

    public function testConstructorAcceptsSerializedArray() {
        $expected = [0, 1, 2];
        $parser = new ArrayParser(serialize($expected));
        $this->assertEquals($expected, $parser->toArray());
    }

    public function testConstructorAcceptsObject() {
        $expected = ['foo' => 'bar'];
        $input = new stdClass;
        $input->foo = 'bar';
        $parser = new ArrayParser($input);
        $this->assertEquals($expected, $parser->toArray());
    }

    public function testtoArrayReturnsArray() {
        $parser = new ArrayParser(serialize([0, 1, 2]));
        $this->assertTrue(is_array($parser->toArray()));
    }
}