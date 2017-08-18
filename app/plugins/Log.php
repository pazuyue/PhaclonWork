<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 17:04
 */
class Log
{
    protected  static $_instance;
    protected  $log_dir ;

    //初始化赋值
    public function __construct(){
        $this->log_dir="RunTime/log/".date("Y-m-d");

    }

    public static function getInstance()
    {
        if(!static::$_instance instanceof static){
            static::$_instance = new static();
        }
        $me = static::$_instance;
        return  $me;
    }

    public function error($message){
        $log_dir =$this->log_dir."/error";
        checkDir($log_dir);
        $logger = new Katzgrau\KLogger\Logger($log_dir,Psr\Log\LogLevel::ERROR,array('extension' => 'log'));
        if(is_array($message))
        {
            $message= json_encode($message);
        }
        $logger->error($message);
    }

}