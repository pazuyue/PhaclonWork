<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 20:55
 */

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Profiler as ProfilerDb;
use Phalcon\Logger;
use Phalcon\Http\Request;

class SqlGetProfiler
{
    protected  static $_instance;
    protected   $loger;
    protected  $request;

    public static function getInstance()
    {
        if(!static::$_instance instanceof static){
            static::$_instance = new static();
        }
        $me = static::$_instance;
        return  $me;
    }

    public function getSqlProfiler()
    {
        //SQL解析
        $eventsManager = new EventsManager();
        // Get a shared instance of the DbProfiler
        $profiler      = new ProfilerDb();
        // Listen all the database events
        $eventsManager->attach('db', function ($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());

                // 检查是否有恶意关键词
                if (preg_match('/DROP|ALTER/i', $connection->getSQLStatement())) {
                    $request = new Request();
                    $ipAddress  =  $request->getClientAddress();
                    $profiles = $profiler->getProfiles();
                    foreach ($profiles as $profile) {
                        $log =$ipAddress."用户在注入！！"."\n";
                        $log .="SQL语句: " . $profile->getSQLStatement() . "\n";
                        Log::error($log);
                    }
                    return false;
                }

            }

            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
                // Get the generated profiles from the profiler
                $profiles = $profiler->getProfiles();

                foreach ($profiles as $profile) {
                    $log = "SQL语句: " . $profile->getSQLStatement() . "\n";
                    $log .= "开始时间: " . $profile->getInitialTime() . "\n";
                    $log .= "结束时间: " . $profile->getFinalTime() . "\n";
                    $log .= "总共执行的时间: " . $profile->getTotalElapsedSeconds() . "\n";
                    Log::notice($log);
                }
            }
        });
        return $eventsManager;
    }

}