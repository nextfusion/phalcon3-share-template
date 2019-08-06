<?php

/* ==================================================
 * Registering a router
 * ================================================== */

$config = $this->config;   // Read the configuration

$manager->set('router', function() use ($config) {
    
    $router = new \Phalcon\Mvc\Router();
    $router->setDefaultModule($config->router->moduleDefault);
    $router->setDefaultNamespace(sprintf('%s\\Controllers', ucfirst($config->router->moduleDefault)));
    $router->setDefaultController($config->router->controllerDefault);
    $router->setDefaultAction($config->router->actionDefault);
    $router->removeExtraSlashes(true);
    
    $router->setDefaults([
        'module'     => $config->router->moduleDefault,
        'controller' => $config->router->controllerDefault,
        'action'     => $config->router->actionDefault
    ]);
    
    $addModule = explode(',', $config->module->moduleLists);
    
    foreach ($addModule as $module) {
        $pathModule = sprintf('%s/Modules/%s/Router.php', APP_PATH, $module);
        $nameModule = sprintf('%sRouter', ucfirst($module));
        if(file_exists($pathModule)){
            include_once $pathModule;
            $router->mount(new $nameModule($config)); 
        }
    }
    
    $router->notFound([
        'module'     => $config->router->moduleDefault,
        'controller' => $config->router->controllerError,
        'action'     => $config->router->actionError
    ]);
    
    return $router;
    
});
