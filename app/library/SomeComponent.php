<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/30
 * Time: 20:38
 */



use Phalcon\Http\Response;

class SomeComponent
{

    protected $_response;

    protected $_someFlag;

    public function __construct($response, $someFlag)
    {
        $this->_response = $response;
        $this->_someFlag = $someFlag;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
    }

    public function setFlag($someFlag)
    {
        $this->_someFlag = $someFlag;
    }

    public function getSomeFlag(){
        return $this->_someFlag;
    }


}
