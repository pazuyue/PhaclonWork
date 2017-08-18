<?php

use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {

        // Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if (empty($auth)) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        // Take the active controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();


        // Obtain the ACL list
       $acl = $this->getAcl();

        // Check if the Role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != Acl::ALLOW) {

            // If he doesn't have access forward him to the index controller
            $this->flash->error("You don't have access to this module");
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action'     => 'index'
                )
            );

            // Returning "false" we tell to the dispatcher to stop the current operation
            return false;
        }
    }


    public function getAcl() {

        if (!isset($this->persistent->acl)) {
            $acl = new Phalcon\Acl\Adapter\Memory();

            //设置默认访问级别为‘拒绝’
            $acl->setDefaultAction(Phalcon\Acl::DENY);

            //创建一些角色 Register roles
            $roles = array(
                'Users'  => new Phalcon\Acl\Role('Users'),
                'Guests' => new Phalcon\Acl\Role('Guests')
            );
            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            //Private area resources
            $privateResources = array(
                'products'     => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete')
            );
            foreach ($privateResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Public area resources
            $publicResources = array(
                 'index'   => array('index'),
                 'user'    => array('index', 'search', 'new', 'edit', 'save', 'create'),
                 'demo'    => array('index'),
                'session' => array('index', 'register', 'start', 'end'),
                'contact' => array('index', 'send')
            );
            foreach ($publicResources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Grant access to public areas to both users and guests
            foreach ($roles as $role) {

                foreach ($publicResources as $resource => $actions) {
                    $acl->allow("Guests", $resource, $actions);
                }
            }

            //Grant acess to private area to role Users
            foreach ($privateResources as $resource => $actions) {
                foreach ($actions as $action){
                    $acl->allow('Users', $resource, $action);
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }
}