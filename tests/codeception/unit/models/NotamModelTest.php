<?php
namespace tests\models;

class NotamModelTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $model;

    protected function _before()
    {
        $this->model = new \app\models\NotamModel;
    }

    public function testIcaoIncorrect()
    {
        foreach ([' ', 'EGLLLONG', '32EG'] as $value) {
            $this->model->attributes = [
                'icao' => $value
            ];
            expect($this->model->validate())->false();
        }
    }

    public function testIcaoCorrect()
    {
        $this->model->attributes = [
            'icao' => 'EGLL'
        ];
        expect($this->model->validate())->true();
    }
}