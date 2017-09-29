<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22
 * Time: 16:02
 */
class MyLogic extends Phalcon\Mvc\User\Logic
{

    public $num = 0;

    public function start()
    {
        // ...
    }

    public function finish()
    {
        // ...
        $this->view->data = $this->getContent();
    }

    // 该方法可以不实现
    public static function call($action = NULL, $params = NULL)
    {
        $logic = new MyLogic($action, $params);
        $logic->num = 1;
        return $logic;
    }

}