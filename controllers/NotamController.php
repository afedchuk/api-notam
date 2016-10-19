<?php
namespace app\controllers;

use Yii;
use Exception;
use yii\web\Controller;
use app\components\Coordinate\Coordinate;
use app\models\NotamModel as Notam;

class NotamController extends ApiController
{
     /**
     * Request Airport NOTAM information
     *
     * @return array
     */
    public function actionIndex()
    {
        $notam = new Notam();
        if(Yii::$app->request->post()) { 
            $notam->load(Yii::$app->request->post());
            if ($notam->validate()) {
                $notams = [];
                $this->client->getNotam(array('reqnotam' => ['icao' =>  $notam->icao]));
                if(!empty($notams = $this->notamResponse()) && $this->statusMessage === null) {
                    foreach ($notams as $key =>  $value) {
                        $geo = new Coordinate(end(explode("/", $value['ItemQ'])));
                        $notams[$key]['geo'] = [
                                'lat' => $geo->getLatitude(),
                                'lng' => $geo->getLongitude()
                        ];
                    }
                } elseif(!is_null($this->statusMessage)) {
                    return ['error', 'message' => $this->statusMessage];
                }
                return ['result' => 'success', 'codes' => $notams];  
            } 
            Yii::$app->end();
        }
        return $this->render('index', ['notam' => $notam]);       
    }
}
