<?php

namespace backend\tests\functional;

use \backend\tests\FunctionalTester;
use common\fixtures\UserFixture as UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
    }
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->amOnPage('/login');
        $I->fillField('LoginForm[username]', 'erau');
        $I->fillField('LoginForm[password]', 'password_0');
        $I->click('login-button');

        //$I->see('Logout (erau)', 'form button[type=submit]');
        $I->see('Sign out', 'a');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
