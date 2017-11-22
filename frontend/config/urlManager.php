<?php
/**
 * Created by PhpStorm.
 * User: Dmitri
 * Date: 17.11.2017
 * Time: 1:23
 */
return [
    'class' => 'yii\web\urlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:login|logout>' => 'site/<_a>',
        '<_c:[\w\-]+>' => '<_c>index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];
