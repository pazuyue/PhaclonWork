<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 16:29
 */

class DemoController extends ControllerBase
{

    public function indexAction(){
        $u = new SerializeUser();
        $u->name = "Leo";
        //$s = serialize($u); //serialize串行化对象u，此处不串行化id属性，id值被抛弃
        //$u2 = unserialize($s); //unserialize反串行化，id值被重新赋值
        //var_dump($s);
        echo "<br>";
        echo "<br>";
        //var_dump($u2);
        echo "<br>";
        echo "<br>";
        //$u("SerializeUser");
        eval('$b = ' . var_export($u, true) . ';');
        var_dump($b);
        return ;
    }

    public function newAction(){
        return "new";
    }



}
