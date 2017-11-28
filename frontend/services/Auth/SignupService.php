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
use yii\mail\MailerInterface;

class SignupService
{

    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

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


        $user = User::signupWithoutConfirmation(
            $form->username,
            $form->email,
            $form->password
        );
        $this->save($user);

        $sent = $this->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . \Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
        return $user;
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }

        $user = $this->getByEmailConfirmToken($token);

        $user->confirmSignup();

        $this->save($user);
    }

    private function save(User $user):void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    private function getByEmailConfirmToken(string $token): User
    {
        /* @var $user User */
        $user = User::findOne(['email_confirm_token' => $token]);

        if(!$user) {
            throw new \DomainException('User is not found.');
        }

        return $user;
    }
}