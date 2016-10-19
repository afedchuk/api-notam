<?php
/**
 * Application configuration shared by all test types
 */
return [
    'language' => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@fixtures',
            'templatePath' => '@templates',
            'namespace' => 'fixtures',
        ],
    ],
    'components' => [
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
