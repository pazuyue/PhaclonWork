<?php


class IndexController extends ControllerBase
{





    public function indexAction()
    {

    }

    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            array(
                'id'   => $user->id,
                'name' => $user->name,
                'Jurisdiction'=>$user->Jurisdiction
            )
        );
    }


    public function registerAction()
    {
        if ($this->request->isPost())
        {
            $username    = $this->request->getPost('username','string');
            $password = $this->request->getPost('password','string');

            // Find the user in the database
            $user = User::findFirst(
                array(
                    "(email = :username: OR username = :username:) AND password = :password: AND active = '1'",
                    'bind' => array(
                        'username'    => $username,
                        'password' => md5($password)
                    )
                )
            );

            if ($user != false) {

                $this->_registerSession($user);

                $this->flash->success('Welcome ' . $user->name);

                // Forward to the 'invoices' controller if the user is valid
                return $this->dispatcher->forward(
                    array(
                        'controller' => 'user',
                        'action'     => 'index'
                    )
                );
            }
            $this->flash->error('密码或者用户名错误！');
            return $this->dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action'     => 'index'
                )
            );

        }



    }

}

