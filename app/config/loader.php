<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->pluginsDir,
        $config->application->globalsDir,
        $config->application->globalsCommonDir,
        $config->application->pluginsEventsDir,
        $config->application->pluginsEventsListenerDir,
        $config->application->controllersValidationDir,
        $config->application->globalsServerDir,
        $config->application->globalsFacadesDir,
        $config->application->LogicDir,
        $config->application->TestDir,
        $config->application->StorageDir,
    ]
)->register();
