<?php

use Phalcon\Di;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 13:55
 */
class Facades
{
    private  static $config;

    public static function register($name)
    {
        if(!isset(self::$config)){
            self::$config = Di::getDefault()->getConfig()->facades;
        }
        if(isset(self::$config[$name])){
            class_alias(self::$config[$name],$name);
            $class = $name::getFacadesAccessor();
            $name::setFacades(new $class);
        }
    }
}