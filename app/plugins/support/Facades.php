<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 16:04
 */
namespace support;
trait Facades
{
    private static $_obj;

    public static function setFacades($_obj)
    {
        self::$_obj = $_obj;
    }

    //动态调用
    public static function __callStatic($name, $arguments=[])
    {
       return call_user_func_array([self::$_obj,$name],$arguments);
    }

    //动态调用
    public function __call($name, $arguments=[])
    {
        return call_user_func_array([self::$_obj,$name],$arguments);
    }

    public function __get($name)
    {
       return self::$_obj->name;
    }
}