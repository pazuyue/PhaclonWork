<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 20:44
 */
interface CacheInterface
{
    public function getKey($cacheKey);

    public function get($cacheKey,$lifetime);

    public function save($cacheKey,$content);

    public function delete($cacheKey);

    public function start($cacheKey);

    public function queryKeys();

}