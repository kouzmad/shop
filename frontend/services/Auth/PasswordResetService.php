<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 24.11.2017
 * Time: 18:15
 */

namespace frontend\services\auth;

use common\entities\User;
use frontend\forms\PasswordResetRequestForm;
use frontend\forms\ResetPasswordForm;
use JsonSchema\Exception\RuntimeException;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService
{

    private $_mailer;
    public function __construct(MailerInterface $mailer){
        $this->_mailer = $mailer;
    }
    /*
    private $_supportMail;
    public function __construct($supportMail, MailerInterface $mailer){
        $this->_supportMail = $supportMail;
        $this->_mailer = $mailer;
    }
    */

    public function request(PasswordResetRequestForm $form) : void
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->requestPasswordReset();

        if (!$user->save()) {
             throw new \DomainException('Saving error');
        }
        /*
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        */

        $sent = $this->_mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            //->setFrom($this->_supportMail)
            ->setTo($form->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending Error');
        }
    }

    public function validateToken($token) :void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }

        if (!$this->existsByPasswordResetToken()) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form) :void
    {
        $user = $this->getByPasswordResetToken($token);
        $user->resetPassword($form->password);

        $this->save($user);
    }

    private function getByEmail(string $email) :User
    {
        /* @var $user User */
        $user = User::findOne([
            'email' =>$email,
        ]);

        if(!$user) {
            throw new \DomainException('User is not found.');
        }

        return $user;
    }

    private function existsByPasswordResetToken(string $token) : bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    private function getByPasswordResetToken(string $token): User
    {
        $user = User::findByPasswordResetToken($token);
        if(!$user) {
            throw new \DomainException('User is not found.');
        }
        return $user;
    }

    private function save(User $user):void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

}