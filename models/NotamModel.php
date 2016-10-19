<?php
namespace app\models;
use yii\base\Model;

class NotamModel extends Model
{
    public $icao;

    public function rules()
    {
        return [
        	['icao', 'required', 'isEmpty' => function ($value) {
		        return empty($value);
		    }],
            ['icao', 'string', 'min' => 4, 'max' => 4],
            ['icao', 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'ICAO can only contain alphabetic characters']
        ];
    }
}