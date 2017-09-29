<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/29
 * Time: 15:34
 */
use support\Facades;
class CacheFacades
{
    use Facades;

    public static function getFacadesAccessor()
    {
        return CacheOutServer::class;
    }
}