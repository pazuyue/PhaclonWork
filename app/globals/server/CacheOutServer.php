<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 20:43
 */
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

class CacheOutServer
{
    protected $cache;
    public function __construct()
    {
        $di = \Phalcon\DI::getDefault();
        $config=$di->get('config');
        $frontCache = new FrontOutput(
            array(
                "lifetime" => 365*24*60*60
            )
        );
        checkDir($config['file']->cacheDir);
        $cache = new BackFile(
            $frontCache,
            array(
                "cacheDir" => $config['file']->cacheDir
            )
        );
        $this->cache = $cache;
    }


    public function getKey($cacheKey)
    {
       $debuginfo = debug_backtrace()[1];

       $title = "file_".$debuginfo['class']."_".$debuginfo['function']."_";
        $key =$title.base64_encode(json_encode($cacheKey));
        return $key;
    }

    public function get($cacheKey, $lifetime=null)
    {
        return $this->cache->get($cacheKey,$lifetime);
    }

    public function save($cacheKey=null, $content=null)
    {
        return  $this->cache->save($cacheKey, $content);
    }

    public function delete($cacheKey)
    {
        return $this->cache->delete($cacheKey);
    }

    public function start($cacheKey){
        return $this->cache->start($cacheKey);
    }

    public function queryKeys(){
        return $this->cache->queryKeys();
    }
}