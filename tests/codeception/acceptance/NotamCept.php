<?php 
namespace tests\codeception\acceptance;

use yii\helpers\Url as Url;
class NotamCept
{
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/notam/index'));
    }
    
    public function testEnsureThatPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that notam page works');
        $I->see('Geo Location for the NOTAM', 'title');
    }

    public function testEnsureThatNotamFormSubmittedCorrect(AcceptanceTester $I)
    {
    	$I->wantTo('ensure tdsfsdfhat notam page works');
    	$I->amGoingTo('submit form with icao code');
		$I->sendAjaxPostRequest('/', array('NotamModel[icao]' => 'EGLL'));
		$I->expect('ajax data with icao codes');
		$I->see('"result":"success"');
    }

    public function testEnsureThatNotamFormSubmittedInCorrect(AcceptanceTester $I)
    {
    	$I->amGoingTo('submit form without icao code');
    	foreach([' ', 'longstring', '2314', 'EGL'] as $value) {
    		$I->sendAjaxPostRequest('/', array('NotamModel[icao]' => $value));
			$I->expect('ajax data with message error');
			$I->see('"result":"error"');
    	}
    	$I->see('You can use only alphabetic charachers and maxlenth equal 4 symbol.');
    }
}