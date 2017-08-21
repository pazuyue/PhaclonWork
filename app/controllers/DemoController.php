<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 17:50
 */
class DemoController
{
    //日记类测试
    public function logTestAction()
    {
        $users = [
            [
                'name' => 'Kenny Katzgrau',
                'username' => 'katzgrau',
            ],
            [
                'name' => 'Dan Horrigan',
                'username' => 'dhrrgn',
            ],
        ];
        Log::getInstance()->debug($users);
    }

    //Cookies保存和获取
    public function getCookiesAction(){
        $this->cookies->set('name', 'yueguang', time() + 7 * 86400);
        $name=trim($this->cookies->get('name')->getValue());
        return $name;
    }

}