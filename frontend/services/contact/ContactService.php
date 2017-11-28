<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 24.11.2017
 * Time: 19:45
 */

namespace frontend\services\contact;
use frontend\forms\ContactForm;
use yii\mail\MailerInterface;

class ContactService
{

    private $_adminEmail;
    private $_mailer;

    public function __construct($adminEmail, MailerInterface $mailer){
        $this->_adminEmail = $adminEmail;
        $this->_mailer = $mailer;
    }

    public function send(ContactForm $form): void
    {
        $sent = $this->_mailer->compose()
            ->setTo($this->_adminEmail)
            ->setFrom($form->email)
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Sending Error');
        }
    }
}