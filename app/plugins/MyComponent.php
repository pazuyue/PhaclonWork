<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 11:02
 */
use Phalcon\Events\EventsAwareInterface;

class MyComponent implements EventsAwareInterface
{
    protected $_eventsManager;

    public function setEventsManager(Phalcon\Events\ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
    }

    public function getEventsManager()
    {
        return $this->_eventsManager;
    }

    public function someTask()
    {
        $this->_eventsManager->fire("my-component:beforeSomeTask", $this);
    }
}