<?php 
namespace app\components;
 
use SoapClient;
use SoapFault;
use SoapVar;
use DomDocument;
use Exception;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\components\XmlFormatter as Xml;
use app\components\Formatter\Formatter;

/**
 * The SOAP Client class.
 */
class Client extends Component
{
    /**
     * @var string $usr the username.
     */
    public $usr;

    /**
     * @var string $usr the password.
     */
    public $passwd;

    /**
     * @var string $url the URL of the WSDL file.
     */
    public $url;

    /**
     * @var array the array of SOAP client options.
     */
    public $options = [];

    /**
     * @var SoapClient the SOAP client instance.
     */
    private $client;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        foreach (['url', 'usr','passwd'] as $key => $value) {
            if($this->$value === null) {
                throw new InvalidConfigException("The $value property must be set.");
            }
        }
        return $this->connect();
    }

    /**
     * @return mixed
     * @throws string $this->passwd | Exception
     */
    private function connect()
    {
        try {
            $this->client = new SoapClient($this->url, $this->options);
        } catch (SoapFault $e) {
            throw new Exception($e->getMessage(), (int) $e->getCode(), $e);
        }
        return $this->client;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, array $arguments)
    {
        try { 
            $node = key(current($arguments));
            $data = array_merge(['USR' => $this->usr, 'PASSWD' => $this->getPasswd()], current($arguments)[key(current($arguments))]);
            $xml = Formatter::make($data, 'xml');
            return $this->__soapCall($name, [$xml->toXml($node)]);
        } catch (SoapFault $e) {
            throw new Exception($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __soapCall($name, $arguments)
    {
        return $this->client->__soapCall($name, $arguments);
    }

    /**
     * Get password for connection
     * @return string
     */
    private function getPasswd()
    {
        return (strlen($this->passwd) == 32 && ctype_xdigit($this->passwd))  ? $this->passwd : md5($this->passwd);
    }
    
    /**
     * Get most recent XML Response returned from SOAP server
     *
     * @return string
     */
    public function getLastResponseXml()
    {   
        if(($lastResponse = $this->client->__getLastResponse())) {
            $response = simplexml_load_string($lastResponse);
            $ns = $response->getNamespaces(true);
            $formatter = Formatter::make($response->children($ns['SOAP-ENV'])->children(), 'array');
            return $formatter->toArray();
        }
        return false;
    }
}
