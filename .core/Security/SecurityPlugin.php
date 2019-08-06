<?php

namespace Base\Security;

class SecurityPlugin extends \Phalcon\Mvc\User\Plugin {
        
    protected $_privilege;

    protected $enabled      = true;
    protected $realtime     = false;
    protected $moduleName   = null;
    
    protected $roleDefault  = 'Guest';
    protected $roles        = [];
    protected $acl          = [];

    public function __construct ($module = null) {

        $baseSystem       = new \CSetting(); 
        $this->enabled    = $baseSystem->securityEnabled;
        $this->realtime   = $baseSystem->securityRealtime;
        $this->moduleName = $module;

        if (ENV_MODE === true) {
            $this->_privilege = new \Phalcon\Config\Adapter\Php(APP_PATH . '/commons/client/privilege.php');
        } else {
            $this->_privilege = new \Phalcon\Config\Adapter\Php(APP_PATH . '/commons/server/privilege.php');
        }

    }
    
    protected function getRole () {

        if (!empty($this->_privilege->roles)) {
            return $this->_privilege->roles;
        }
        
        return [];

    }

    protected function getAccessList () {

        $moduleName = $this->moduleName;

        if (!empty($this->_privilege->resource->$moduleName)) { 
            return $this->_privilege->resource->$moduleName;
        }

        unset($moduleName);
        return !empty($resource) ? $resource : []; 

    }
    
    public function getAcl () {
         
        // รับแบบ Realtime
        
        if (!empty($this->realtime)) {
        
            $this->acl   = new \Phalcon\Acl\Adapter\Memory();

            $this->roles = $this->getRole();
            $this->acl   = new \Phalcon\Acl\Adapter\Memory();
            $this->acl->setDefaultAction(\Phalcon\Acl::DENY);

            // ลงทะเบียน Role ทั้งหมด
            foreach ($this->roles as $role) {
                $this->acl->addRole(new \Phalcon\Acl\Role(ucfirst($role))); // Owner, Member, Guest
            }

            // ดึงข้อมูลสิทธ์ให้กับผู้ใช้งานทั้งหมด
            $accessList = $this->getAccessList();

            if (!empty($accessList) && count($accessList) >= 1) {

                foreach ($accessList as $roleName => $controllers) {

                    foreach ($controllers as $controllerName => $actions) {

                        $this->acl->addResource(new \Phalcon\Acl\Resource($controllerName), (array) $actions);

                        foreach ($actions as $action) {

                            $this->acl->allow($roleName, $controllerName, $action); // add allow

                        }

                    }

                    if (!empty($this->_privilege->resourceError)) {

                        $this->acl->addResource(new \Phalcon\Acl\Resource('error'), (array) $this->_privilege->resourceError);

                        foreach ($this->_privilege->resourceError as $action) {

                            $this->acl->allow($roleName, 'error', $action); // add allow

                        }

                    }

                }

            }

            $this->persistent->acl = $this->acl;
            
        } else {
            
            if (!is_file(APP_PATH . '/security/acl.data')) {
                
                $this->acl   = new \Phalcon\Acl\Adapter\Memory();

                $this->roles = $this->getRole();
                $this->acl   = new \Phalcon\Acl\Adapter\Memory();
                $this->acl->setDefaultAction(\Phalcon\Acl::DENY);

                // ลงทะเบียน Role ทั้งหมด
                foreach ($this->roles as $role) {
                    $this->acl->addRole(new \Phalcon\Acl\Role(ucfirst($role))); // Owner, Member, Guest
                }

                // ดึงข้อมูลสิทธ์ให้กับผู้ใช้งานทั้งหมด
                $accessList = $this->getAccessList();

                if (!empty($accessList) && count($accessList) >= 1) {

                    foreach ($accessList as $roleName => $controllers) {

                        foreach ($controllers as $controllerName => $actions) {

                            $this->acl->addResource(new \Phalcon\Acl\Resource($controllerName), (array) $actions);

                            foreach ($actions as $action) {

                                $this->acl->allow($roleName, $controllerName, $action); // add allow

                            }

                        }

                        if (!empty($this->_privilege->resourceError)) {

                            $this->acl->addResource(new \Phalcon\Acl\Resource('error'), (array) $this->_privilege->resourceError);

                            foreach ($this->_privilege->resourceError as $action) {

                                $this->acl->allow($roleName, 'error', $action); // add allow

                            }
                            
                        }

                    }

                }

                $this->persistent->acl = $this->acl;
                
                file_put_contents(APP_PATH . '/security/acl.data', serialize($this->acl));
                
            } else {
                
                $this->acl = unserialize(file_get_contents(APP_PATH . '/security/acl.data'));
                $this->persistent->acl = $this->acl;
                
            }
            
        }
        
        return $this->persistent->acl;
        
    }
    
    public function beforeException (\Phalcon\Events\Event $event = null, \Phalcon\Mvc\Dispatcher $dispatcher = null, $exception = null) {
        
        // Handle 404 exceptions
        if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
            $dispatcher->forward([
                // 'namespace'  => $dispatcher->getNamespaceName(),
                'namespace'  => 'Frontend\\Controllers',
                'controller' => 'error',
                'action'     => 'route404'
            ]);
            return false;
        }

        // Handle other exceptions
        switch ($exception->getCode()) {
            case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward([
                    // 'namespace'  => $dispatcher->getNamespaceName(),
                    'namespace'  => 'Frontend\\Controllers',
                    'controller' => 'error',
                    'action'     => 'route500'
                ]);
                return false;
        }
        
        unset($event);
        
    }

    public function beforeExecuteRoute (\Phalcon\Events\Event $event = null, \Phalcon\Mvc\Dispatcher $dispatcher = null) {
        
        if (!empty($this->enabled)) {
            
            $role =  !empty($this->_privilege->roleDefault) ? $this->_privilege->roleDefault : $this->roleDefault;

            if (!empty($this->session->has('auth'))) {
                
                $auth = $this->session->get('auth');
                $role = !empty($auth->role) ? $auth->role : $role; 
                unset($auth);
                
            } else {

                $response = new \Phalcon\Http\Response();
                $response->redirect('/../signin', true);
                $response->send();
                return false;

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
    
    # ==========================================================================
    
    protected function getRoleText ($allowed = null, $role = null, $dispatcher = null) {
        
        // $activeMethod = $dispatcher->getActiveMethod();
        $namespace    = $dispatcher->getNamespaceName();
        $moduleName   = $dispatcher->getModuleName();
        $controller   = $dispatcher->getControllerName();
        $action       = $dispatcher->getActionName();
        
        if ($allowed != \Phalcon\Acl::ALLOW) {
            echo 'Allowed : FALSE';
        } else {
            echo 'Allowed : TRUE';
        }
       
        echo '<br />';
        echo 'Role : ' . $role;
        echo '<br />';
        echo 'Namespace : ' . $namespace;
        echo '<br />';
        echo 'Module : ' . $moduleName;
        echo '<br />';
        echo 'Controller : ' . $controller;
        echo '<br />';
        echo 'Action : ' . $action . 'Action()'; 
        echo '<br />';
        
        echo '<pre>'; print_r($this->getAcl()); echo '</pre>';
        
        exit();
            
    }

    protected function getValue ($data = []) {
        echo '<meta charset="utf-8"><pre>'; print_r($data); echo '</pre>'; exit();
    }
    
}