<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 17:47
 */
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class UserValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            'name',
            new PresenceOf(
                array(
                    'message' => '名字不能为空'
                )
            )
        );

        $this->add(
            'email',
            new PresenceOf(
                array(
                    'message' => 'email不能为空'
                )
            )
        );

        $this->add(
            'email',
            new Email(
                array(
                    'message' => 'email格式不对'
                )
            )
        );
    }
}