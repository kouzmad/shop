<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 23.11.2017
 * Time: 11:48
 */

namespace common\bootstrap;


use frontend\services\auth\PasswordResetService;
use frontend\services\contact\ContactService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        //$container->setSingleton(PasswordResetService::class);

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ContactService::class, [], [
            //$app->params['adminEmail'],
            //\Yii::$app->params['adminEmail'],
            'aa@aa.bb'
            //todo починить для тестов
        ]);

        /*
        $container->setSingleton(PasswordResetService::class, [], [
            [$app->params['supportEmail'] => $app->name . ' robot'],
            $app->mailer
        ]);
        */
        /*
        $container->setSingleton(PasswordResetService::class, function () use ($app) {
            return new PasswordResetService([$app->params['supportEmail'] => $app->name . ' robot']);
        });*/
    }

}