<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 22:33
 */
class SerializeUser
{
    public $name;
    public $id;

    public function __construct() {    // 给id成员赋一个uniq id
        $this->id = uniqid();
    }

    public function __sleep() {       //此处不串行化id成员
        return(array('name'));
    }

    public function __wakeup() {
        $this->id = uniqid();
    }

    function __invoke($x) {
        var_dump($x);
    }

    public static function __set_state($an_array) // As of PHP 5.1.0
    {
        $obj = new SerializeUser;
        $obj->name = "BiBi";
        return $obj;
    }
}