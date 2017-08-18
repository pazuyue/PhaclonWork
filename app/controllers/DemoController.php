<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 17:50
 */
class DemoController
{
    //日记类收费
    public function log()
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
        Log::getInstance()->error($users);
    }

}