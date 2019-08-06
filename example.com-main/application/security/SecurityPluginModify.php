<?php

namespace Multiple\Security;

class SecurityPluginModify extends \Base\Security\SecurityPlugin {

    public function beforeExecuteRoute (\Phalcon\Events\Event $event = null, \Phalcon\Mvc\Dispatcher $dispatcher = null) {
        
        if (!empty($this->enabled)) {
            
            $role =  !empty($this->_privilege->roleDefault) ? $this->_privilege->roleDefault : $this->roleDefault;

            if (!empty($this->session->has('auth'))) {
                
                $auth = $this->session->get('auth');
                $role = !empty($auth->role) ? $auth->role : $role; 
                unset($auth);

            }
            
            $moduleName   = $dispatcher->getModuleName();
            $controller   = $dispatcher->getControllerName();
            $action       = $dispatcher->getActionName();
            
            $allowed      = $this->getAcl()->isAllowed($role, $controller, $action);

            // $this->getValue([ $allowed, \Phalcon\Acl::ALLOW,  $moduleName, $controller, $action ]);
            // $this->getRoleText($allowed, $role, $dispatcher);
            
            // ไม่มีสิทธิ์เข้าใช้งาน
            if ($allowed != \Phalcon\Acl::ALLOW) {

                /*
                $response = new \Phalcon\Http\Response();
                $response->redirect('/../signin', true);
                $response->send();
                */

                $dispatcher->forward([
                    // 'namespace'  => $dispatcher->getNamespaceName(),
                    'namespace'  => 'Frontend\\Controllers',
                    'controller' => 'error',
                    'action'     => 'route401'
                ]);
                
                return false;
                
            }
            
        } else {
            
            return true;
            
        }
        
        unset($event);
        
    }
    
}