<?php
use Phalcon\Mvc\Micro;

use Phalcon\Logger;
use Phalcon\Logger\Multiple as MultipleStream;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

class IndexController extends ControllerBase
{

    public function beforeExecuteRoute($dispatcher)
    {
        /*$logger = new FileAdapter("./RunTime/log/2016-2/20160203.log");  //初始化文件地址
        $logger->log("This is a message");                                  //写入普通log
        $logger->log("This is an error", \Phalcon\Logger::ERROR);         //写入error信息
        $logger->error("This is another error");                          //于上一句同义

        $logger = new MultipleStream();
        $logger->push(new FileAdapter('./RunTime/log/2016-2/test.log'));
        $logger->push(new StreamAdapter('php://stdout'));
        $logger->log("This is a message");
        $logger->log("This is an error", Logger::ERROR);
        $logger->error("This is another error");*/

        //$response = $this->response;
       //   $response->appendContent('test');                          //添加一段返回类容
       // $response->setJsonContent(array('Response' => 'ok'));      //返回一个json,参数必须是数组
       // $response->setContent("<h1>Hello!</h1>");                  //返回需要显示在页面上的内容
        //$response->setStatusCode(404, "Not Found");                //返回http请求状态,以及msg
       // return $response->send();

        // This is executed before every found action
       /* if ($dispatcher->getActionName() == 'save') {

            $this->flash->error("You don't have permission to save posts");

            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));

            return false;
        }*/
    }




    public function afterExecuteRoute($dispatcher)
    {
        $this->flash->error($dispatcher->getActionName()." IS COME");

    }


    public function saveAction(){
        echo "SAVE Ing";
        $this->flash->error("OK");
    }



    public function indexAction()
    {

    }


    public function registerAction()
    {
        $user = new User();

        $userinfo = $this->request->getPost();

        $userinfo['password']=md5($userinfo ['password']);
        var_dump($userinfo);
        // 存储和检验错误
        $success = $user->save(
            $userinfo,
            [
                "name",
                "email",
                "sex",
                "username",
                "password"
            ]
        );

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }

}

