<?php
namespace tests\codeception\unit\components;

use Yii;
use SoapClient;
use SoapFault;
use app\components\Client;

class ClientTest extends \Codeception\TestCase\Test
{
    private $client;

    private $user = 'testuser';
    private $password = 'testpassword';

    protected function _before()
    {
        $this->client = Yii::$app->api;
        $this->client->init();
    }

    public function testClientIsInstanceOfSoapClient() {
        $this->assertTrue(true, is_a($this->client, 'SoapClient'));
    }


    public function testClientNotExixtsIcaoOrEmptyListNotams()
    {
        $expected = ["RESULT" => 0, "NOTAMSET"=>["@attributes" => ["ICAO" => "SBSD"]]];
        $this->client->getNotam(array('reqnotam' => ['icao' =>  'SBSD']));
        $this->assertEquals($expected, $this->client->getLastResponseXml());
    }

    public function testClientUSernameOrPasswordIncorrect() {
        $this->client->usr = $this->user;
        $this->client->passwd = $this->password;
        $this->client->getNotam(array('reqnotam' => ['icao' =>  'TEST']));
        $response = $this->client->getLastResponseXml();

        $this->assertEquals(["RESULT" => "8", "MESSAGE"=> 'Incorrect username or password'], $response);
    }
}