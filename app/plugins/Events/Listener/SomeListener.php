<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 11:06
 */
use Phalcon\Db\Profiler as ProfilerDb;

class SomeListener
{
    public function beforeSomeTask($event, $myComponent)
    {
        echo "这里, beforeSomeTask\n";
    }

    public function afterSomeTask($event, $myComponent)
    {
        echo "这里, afterSomeTask\n";
    }
}