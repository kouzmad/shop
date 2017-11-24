<?php
/**
 * Created by PhpStorm.
 * User: kouzma
 * Date: 24.11.2017
 * Time: 13:51
 */

namespace  commoon\entities;

trait InstantiateTrait
{
    private static  $_prototype;

    public static function  instantiate($row)
    {
        if (self::$_prototype === null) {
            $class = get_called_class();
            self::$_prototype = unserialize(sprtintf('0:%d:"%s":0:{}', strlen($class), $class));
        }
        $entity = clone self::$_prototype;
        $entity->init();
        return $entity;
    }

}