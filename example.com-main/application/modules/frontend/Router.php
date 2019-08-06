<?php

class FrontendRouter extends \Phalcon\Mvc\Router\Group {
    
    private $moduleDefault      = 'frontend';
    private $controllerDefault  = 'main';
    private $actionDefault      = 'index';
    
    private $routerErrors = [
        'controller' => 'error',
        'action'     => 'route404'
    ];
    
    public function __construct ($config = []) {
        $this->routerErrors      = array_merge(['module' => $this->moduleDefault], $this->routerErrors);
        $this->actionDefault     = $config->router->actionDefault;
        $this->controllerDefault = $config->router->controllerDefault;
        parent::__construct();
    }
    
    public function initialize () {
        
        if (ENV_MODE === true) {
            $config = new \Phalcon\Config\Adapter\Php(sprintf('%s/commons/client/routers.php', APP_PATH));
        } else {
            $config = new \Phalcon\Config\Adapter\Php(sprintf('%s/commons/server/routers.php', APP_PATH));
        }
        
        // Default paths
        $this->setPaths([
            'module'    => $this->moduleDefault,
            'namespace' => sprintf('%s\\Controllers', ucfirst($this->moduleDefault))
        ]);

        /*
        if (!empty($config[$this->moduleDefault] )) { 

            foreach ($config[$this->moduleDefault] as $controllerName => $actions) {
                
                foreach ($actions as $action) {
                    
                    $this->add(sprintf('/%s/%s/%s/:params', $controllerName, $action, $action), [
                        'module'     => $this->moduleDefault,
                        'controller' => $controllerName,
                        'action'     => $action,
                        'params'     => 1
                    ]);
                    
                    $this->add(sprintf('/%s/%s/', $controllerName, $action), [
                        'module'     => $this->moduleDefault,
                        'controller' => $controllerName,
                        'action'     => $action
                    ]);
                    
                    $this->add(sprintf('/%s/%s', $controllerName, $action), [
                        'module'     => $this->moduleDefault,
                        'controller' => $controllerName,
                        'action'     => $action
                    ]);
                    
                }
                
                $this->add(sprintf('/%s/', $controllerName), [
                    'module'     => $this->moduleDefault,
                    'controller' => $controllerName,
                    'action'     => 'index'
                ]);
                
                $this->add(sprintf('/%s', $controllerName), [
                    'module'     => $this->moduleDefault,
                    'controller' => $controllerName,
                    'action'     => 'index'
                ]);
                
            }
        
        }
        */
        
        /*
        $this->add('/:controller/:action/:params', [ 'module' => 1, 'controller' => 2, 'action' => 3 ]);
        $this->add('/:controller/:action/', [ 'module' => $this->moduleDefault, 'controller' => 1, 'action' => 2 ]);
        $this->add('/:controller/:action', [ 'module' => $this->moduleDefault, 'controller' => 1, 'action' => 2 ]);
        $this->add('/:controller/', [ 'module' => $this->moduleDefault, 'controller' => 1, 'action' => 'index' ]);
        $this->add('/:controller', [ 'module' => $this->moduleDefault, 'controller' => 1, 'action' => 'index' ]);
        */
        
        $this->addGet('/', [ 'module' => $this->moduleDefault, 'controller' => $this->controllerDefault, 'action' => $this->actionDefault ]);
        $this->addGet('',  [ 'module' => $this->moduleDefault, 'controller' => $this->controllerDefault, 'action' => $this->actionDefault ]);
        
    }
    
}
