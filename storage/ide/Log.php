<?php

/**
 * Created by PhpStorm.
 * User: 月光
 * Date: 2017/9/11
 * Time: 16:20
 */
class Log
{

    public function __construct(){}
    /**
     * 错误类型的日记录入
     * @param $message::消息
     **/
    public static function  error($message){}

    /**
     * 消息类型的日记录入
     * @param $message::消息
     **/
    public static function info($message){}

    /**
     * 系统信息类型的日记录入
     * @param $message::消息
     **/
    public static function debug($message){}

    /**
     * 一般类型的日记录入
     * @param $message::消息
     **/
    public static function notice($message){}
}