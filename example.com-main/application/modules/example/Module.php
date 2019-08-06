<?php

namespace Example;

class Module extends \Multiple\Components\CModule {
    
    protected $moduleName = 'example';
    
    /* ==================================================
     * Register 
     * ================================================== */
    
    public function registerAutoloaders (\Phalcon\DiInterface $manager = null) {
        
        parent::registerAutoloaders($manager);
        
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(
            array_merge([
                ucfirst($this->moduleName) . '\\Controllers' =>  __DIR__ . '/controllers/',
                ucfirst($this->moduleName) . '\\Models'      =>  __DIR__ . '/models/',
            ], $this->namespaces)
        )->register();
        
    }
    
    public function registerServices (\Phalcon\DiInterface $manager = null) {
        
        $this->viewDir = sprintf('%s/%s/', __DIR__ , 'views');
        parent::registerServices($manager);
        
    }
    
}
