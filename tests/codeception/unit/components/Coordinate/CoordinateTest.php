<?php
namespace components\Coordinate;

use app\components\Coordinate\Coordinate;
use app\components\Coordinate\CoordinateInterface;
use yii\base\InvalidParamException;

class CoordinateTest extends \Codeception\TestCase\Test
{
    public function testCoordinateIsInstanceOfCoordinateInterface() {
        $parser = new Coordinate('5126N00024W');
        $this->assertTrue($parser instanceof CoordinateInterface);
    }

    public function testCoordinateIcaoNotamCoordinates()
    {
        $geo = new Coordinate('5126N00024W');
        $this->assertEquals(51.433333333333,  $geo->getLatitude());
        $this->assertEquals(-0.4, $geo->getLongitude());
    }

    public function testCoordinateIncorrectFormatCoordinates()
    {
        try {
           $obj = new Coordinate(['5126N', '00024W']);
        } catch (InvalidParamException $e) {
            $this->assertEquals($e->getMessage(), 'The given coordinates should be a string!');
            return;
        }
        $this->fail();
    }
}