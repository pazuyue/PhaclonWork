<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 20:44
 */
class Cache
{
    public static function getKey($cacheKey){}

    public static function get($cacheKey,$lifetime){}

    public static function save($cacheKey,$content){}

    public static function delete($cacheKey){}

    public static function start($cacheKey){}

    public static function queryKeys(){}

}