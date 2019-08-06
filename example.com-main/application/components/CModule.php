<?php

namespace Multiple\Components;

class CModule extends \Base\Components\CModule {
    
    /* ==================================================
     * Register 
     * ================================================== */
    
    public function registerAutoloaders (\Phalcon\DiInterface $manager = null) {
       
        parent::registerAutoloaders($manager);
        
        $this->namespaces = array_merge($this->namespaces, [
            'Multiple\\Components' => APP_PATH . '/' . $this->config->app->componentsDir,
            'Multiple\\Plugins'    => APP_PATH . '/' . $this->config->app->pluginsDir,
            'Multiple\\Security'   => APP_PATH . '/' . $this->config->app->securityDir,
            'Multiple\\Librarys'   => APP_PATH . '/' . $this->config->app->librarysDir,
        ]);

        include_once APP_PATH . '/commons/services.php';
        
    }
    
}