<?php
namespace tests\codeception\functional;

class NotamCest
{

    protected $formId = '#w0';

    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage('/');
    }

    public function openNotamPage(\FunctionalTester $I)
    {
         $I->see('Geo Location for the NOTAM', 'title');
    }

    public function submitIcaoNotam(\FunctionalTester $I)
    {
        $I->sendAjaxPostRequest('/', array('NotamModel[icao]' => 'EGLL'));
        $I->expectTo('see notam json information');
        $I->see('"result":"success"');
    }

}