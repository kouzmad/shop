<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 24.11.2017
 * Time: 15:04
 */

namespace frontend\services\auth;

use common\entities\User;
use frontend\forms\SignupForm;

class SignupService
{
    public function signup(SignupForm $form)
    {
/*
        echo '---' . $form->username;
        echo '<pre>';
            print_r(User::find()->andWhere(['username' => $form->username]));
        echo '</pre>';
        exit();*/
/*
        if (User::find()->andWhere(['username' => $form->username])) {
            throw new \DomainException('Username is alredy exists.');
        }
        if (User::find()->andWhere(['email' => $form->email])) {
            throw new \DomainException('Email is alredy exists.');
        }*/


        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
        return $user;
    }
}