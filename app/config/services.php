<?php


use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Crypt;
use Phalcon\Http\Response\Cookies;
use Phalcon\Security;

use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});



/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function ()  use ($di){

    $config = $this->getConfig();
    if(APP_DEBUG)  $eventsManager=  SqlGetProfiler::getInstance()->getSqlProfiler();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $connection = new $class($params);

    // Assign the eventsManager to the db adapter instance
    if(APP_DEBUG) $connection->setEventsManager($eventsManager);

    return $connection;
});

$di->setShared('mogodb', function ()  use ($di){
    $config = $this->getConfig();
    $manager = new MongoDB\Driver\Manager("mongodb://".$config->mogodb->host);
    return $manager;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

// 利用自定义的CSS类来注册flash服务
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

$di->setShared('cookies', function () {
    $cookies = new Cookies();
    //$cookies->useEncryption(false);
    return $cookies;
});

$di->setShared('crypt', function () {
    $crypt = new Crypt();
    $crypt->setKey('yueguang'); // 使用你自己的key！
    return $crypt;
});


/**
 * Start the session the first time some component request the session service
 */
$di->setShared('dispatcher', function () {

    $eventsManager = new EventsManager();

    // 在执行控制器/动作方法前触发。此时，调度器已经初始化了控制器并知道动作是否存在。
    $eventsManager->attach('dispatch:beforeExecuteRoute',new SecurityPlugin);

    // 在调度器抛出任意异常前触发
    //$eventsManager->attach('dispatch:beforeException',new Exception);

    $dispatcher = new Dispatcher();

    // Assign the events manager to the dispatcher
    $dispatcher->setEventsManager($eventsManager);


    return $dispatcher;
});

$di->set('security', function () {

    $security = new Security();
    // Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);
    return $security;
}, true);

$di->set(
    "modelsManager",
    function() {
        return new ModelsManager();
    }
);



$di->set(
    "modelsCache",
    function () {
        // 默认缓存时间为一天
        $frontCache = new FrontData(
            [
                "lifetime" => 86400,
            ]
        );
        $config = $this->getConfig();
        // Memcached连接配置 这里使用的是Memcache适配器
        checkDir($config['file']->cacheDir);
        $cache = new BackFile(
            $frontCache,
            array(
                "cacheDir" => $config['file']->cacheDir
            )
        );
        return $cache;
    }
);


