<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 16:01
 */
use support\Facades;
class LogFacades
{
    use Facades;

    public static function getFacadesAccessor()
    {
        return LogService::class;
    }
}