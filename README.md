Get notam information by ICAO code using SOAP
============================

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer
composer update

~~~
http://localhost/basic/web/
~~~


CONFIGURATION
-------------

[
  // soap client configurations
  'class' => 'app\components\Client',
  'usr' => 'usertest@gmail.com',
  'passwd' => 'usrpassword',
  'url' => 'https://api.com/notam/service.wsdl',
  'options' => [
      'trace' => true,
      'use' => SOAP_LITERAL,
      'cache_wsdl' => WSDL_CACHE_NONE,
  ]
  // for using google maps
  'params' => [
        'googleApi' => 'google_api_key'
  ]
]
