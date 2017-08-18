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
                    $logDir="RunTime/log/".date("Y-m-d");
                    if (!is_dir($logDir)) mkdir($logDir);
                    $logger = new FileLogger($logDir."/info.log");
                    foreach ($profiles as $profile) {
                        $log = "SQL Statement: " . $profile->getSQLStatement() . "\n";
                        $log .= "Start Time: " . $profile->getInitialTime() . "\n";
                        $log .= "Final Time: " . $profile->getFinalTime() . "\n";
                        $log .= "Total Elapsed Time: " . $profile->getTotalElapsedSeconds() . "\n";
                        $logger->log($log, Logger::INFO);
                    }
                }
            });
                return $eventsManager;
    }

}