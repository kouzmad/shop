<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 24.11.2017
 * Time: 13:43
 */

namespace unit\entities\User;
use Codeception\Test\Unit;
use common\entities\User;

class SignUpTest extends Unit
{
    public function testSuccess() {

        $user = User::signup(
            $username= 'username',
            $email = 'email@site.com',
            $password = 'password'
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertTrue($user->isActive());

    }
}