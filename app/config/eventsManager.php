<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 11:36
 */

use Phalcon\Events\Manager as EventsManager;

// 创建一个事件管理器
$eventsManager = new EventsManager();

// 创建MyComponent实例
$myComponent   = new MyComponent();

// 将事件管理器绑定到创建MyComponent实例实例
$myComponent->setEventsManager($eventsManager);

// 为事件管理器附上侦听者
//$eventsManager->attach('my-component', new SomeListener());

// 执行组件的方法
$myComponent->someTask();