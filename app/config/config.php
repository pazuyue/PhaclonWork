<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');
defined('APP_DEBUG') || define('APP_DEBUG',TRUE);

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'root',
        'dbname'      => 'test',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/modules/controllers/',
        'controllersValidationDir'=> APP_PATH . '/modules/controllers/validation/',
        'modelsDir'      => APP_PATH . '/modules/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'pluginsEventsDir'     => APP_PATH . '/plugins/Events',
        'pluginsEventsListenerDir'     => APP_PATH . '/plugins/Events/Listener',
        'libraryDir'     => APP_PATH . '/library/',
        'globalsDir'       => APP_PATH . '/globals/',
        'globalsCommonDir'       => APP_PATH . '/globals/common/',
        'globalsServerDir'       => APP_PATH . '/globals/server/',
        'globalsFacadesDir'       => APP_PATH . '/globals/facades/',
        'LogicDir'       => APP_PATH . '/modules/logic/',
        'TasksDir'       => APP_PATH . '/tasks/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'TestDir'       => BASE_PATH . '/public/tests',
        'StorageDir'       => BASE_PATH . '/storage',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    'file'=>[
        'cacheDir'=> BASE_PATH . '/cache/output/',
    ],

    'facades'=>include_once APP_PATH.'/globals/facades/facades.cfg.php',
]);
