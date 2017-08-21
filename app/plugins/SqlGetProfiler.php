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

class SqlGetProfiler
{
    protected  static $_instance;

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
        $di = new \Phalcon\DI\FactoryDefault();
        $di->setShared('profiler', function () {
            return new ProfilerDb();
        });
        //SQL解析
        $eventsManager = new EventsManager();
        // Get a shared instance of the DbProfiler
        $profiler      = $di->getProfiler();
        // Listen all the database events
        $eventsManager->attach('db', function ($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
            }

            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
                // Get the generated profiles from the profiler
                $profiles = $profiler->getProfiles();
                $loger= Log::getInstance();
                foreach ($profiles as $profile) {
                    $log = "SQL语句: " . $profile->getSQLStatement() . "\n";
                    $log .= "开始时间: " . $profile->getInitialTime() . "\n";
                    $log .= "结束时间: " . $profile->getFinalTime() . "\n";
                    $log .= "总共执行的时间: " . $profile->getTotalElapsedSeconds() . "\n";
                    $loger->notice($log);
                }
            }
        });
        return $eventsManager;
    }

}