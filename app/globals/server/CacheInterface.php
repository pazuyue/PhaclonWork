<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 20:44
 */
interface CacheInterface
{
    public function getKey($key);

    public function get($key,$lifetime);

    public function save($key,$content);

    public function delete($key);

    public function start($cacheKey);

}