<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/14
 * Time: 13:39
 */

class QueryListController extends ControllerBase
{

    public function QueryListAction(){
        $QueryListLoogic = new QueryListLoogic();
        $QueryListLoogic->findInfoByMogoDB();
    }

}