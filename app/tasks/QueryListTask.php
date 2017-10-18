<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/14
 * Time: 13:47
 */

class QueryListTask extends \Phalcon\CLI\Task
{
    public function queryListAction($page){
        $page = isset($page[0]) ? $page[0] : 1;
        $QueryListLoogic = new QueryListLoogic();
        $QueryListLoogic->findInfoByMogoDB($page);
    }

    public function mainAction() {
        echo "\nThis is the default task and the default action \n";
    }

}