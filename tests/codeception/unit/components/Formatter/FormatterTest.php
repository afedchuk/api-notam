<?php
namespace components\Formatter;

use yii\base\InvalidParamException;
use app\components\Formatter\Formatter;

class FormatterTest extends \Codeception\TestCase\Test
{
    public function testFormatterProvidesXmlConstant() {
        $expected = 'xml';
        $actual = Formatter::XML;
        $this->assertEquals($expected, $actual);
    }

    public function testFormatterProvidesArrayConstant() {
        $expected = 'array';
        $actual = Formatter::ARR;
        $this->assertEquals($expected, $actual);
    }

    public function testFormatterMakeThrowsInvalidTypeException() {
        try {            
            $formatter = Formatter::make('', 'blue');
        } catch (InvalidParamException $e) {
            $this->assertEquals($e->getMessage(), 'make function only accepts [xml, array] for $type but blue was provided.');
            return;        
        }
        $this->fail();
    }

    public function testFormatterMakeReturnsInstanceOfFormatter() {
        $formatter = Formatter::make('', Formatter::XML);
        $this->assertTrue($formatter instanceof Formatter);
    }
}