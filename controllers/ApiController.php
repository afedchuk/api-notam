<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\components\Coordinate\Coordinate;

class ApiController extends Controller 
{
	protected $client;

	protected $statusMessage;

	public function behaviors()
	{
		$response = (Yii::$app->request->isAjax) ? ['application/json' => Response::FORMAT_JSON] : ['text/html' => Response::FORMAT_HTML];
	    return [
	        [
	            'class' => 'yii\filters\ContentNegotiator',
	            'only' => ['index', 'view'],
	            'formats' => $response
	        ],
	    ];

	}

	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function __construct($id, $module, $config = [])
	{
		if(Yii::$app->request->isAjax) {
		  $this->layout = false;
		  $this->enableCsrfValidation = false;
		}

	  	$this->client = Yii::$app->api;
	    parent::__construct($id, $module, $config);
	}


    protected function notamResponse()
    {
    	$responseData = [];
    	$response = $this->client->getLastResponseXml();
    	if(isset($response["RESULT"]) && $response["RESULT"] == 0) {
    		if(isset($response["NOTAMSET"]["NOTAM"])) {
	            foreach ($response["NOTAMSET"]["NOTAM"] as $key => $value) {
                    array_push($responseData, $response["NOTAMSET"]["NOTAM"][$key]);
	            }
	        }
        } else {
        	$this->statusMessage = $response['MESSAGE'];
        }
    	return $responseData;

    }
}