<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 16:20
 */
class Log
{
    protected  static $_instance;
    protected  $log_dir ;

    public function __construct(){}

    public static function  error($message){}

    public static function info($message){}

    public static function debug($message){}

    public static function notice($message){}
}