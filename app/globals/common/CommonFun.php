<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 15:40
 */

/*断点调试*/
function pre_var($total){
    echo "<pre>";
    var_dump($total);
    echo "</pre>";
    die();
}

/*检查目录是否存在，不存在新建*/
function checkDir($logDir){
    if (!is_dir($logDir)) mkdir($logDir);
}