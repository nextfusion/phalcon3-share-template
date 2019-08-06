<?php

namespace Base\Components;

class CModule implements \Phalcon\Mvc\ModuleDefinitionInterface {
    
    protected $config      = [];
    protected $moduleName  = 'frontend';
    protected $namespaces  = [];
    protected $viewDir     = '';

    /* ==================================================
     * Register 
     * ================================================== */
    
    public function registerAutoloaders (\Phalcon\DiInterface $manager = null) {
       
        if (ENV_MODE === TRUE) {
            $this->config = new \Phalcon\Config\Adapter\Ini(CORE_PATH . '/Commons/client.ini');
            $this->config->merge(new \Phalcon\Config\Adapter\Ini(APP_PATH . '/commons/client/config.ini'));
        } else {
            $this->config = new \Phalcon\Config\Adapter\Ini(CORE_PATH . '/Commons/server.ini');
            $this->config->merge(new \Phalcon\Config\Adapter\Ini(APP_PATH . '/commons/server/config.ini'));
        }
        
        $this->namespaces = [
            'Base'                    => sprintf('%s/', CORE_PATH),
            'Phalcon'                 => sprintf('%s/Vendor/incubator', CORE_PATH),
            'Base\\Models\\Maria'     => sprintf('%s/models/%s/mariadb', CORE_PATH, 'db_base'),
            'Base\\Models\\Mongo'     => sprintf('%s/models/%s/mongo', CORE_PATH, 'db_base'),
        ];

        include_once CORE_PATH . '/services.php';

    }
    
    public function registerServices (\Phalcon\DiInterface $manager) {
        
        // Security
        $this->setSecurity($manager, $this->moduleName);
          
        // View
        $this->setView($manager, (object)[
            'viewDir'=> $this->viewDir,
            'config' => $this->config,
            'module' => $this->moduleName,
            'theme'  => $this->config->module->themeDefault,
            'layout' => $this->config->module->layoutDefault
        ]);
        
    }
    
    /* ==================================================
     * View
     * ================================================== */ 
    
    protected function setView ($manager, $params) {
        
        $manager->set('view', function () use ($params) {
            
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir($params->viewDir); /* ตำแหน่งเก็บไฟล์ views ทั้งหมด */
            $view->setLayoutsDir(sprintf('%s/%s/', $params->config->theme->themesDir, $params->theme)); /* ตำแหน่งเก็บไฟล์ layouts ทั้งหมด */
            $view->setTemplateAfter('layouts/' . $params->layout); /* เลือกไฟล์ layout เริ่มต้น*/
            
            /* โฟล์เดอร์เก็บไฟล์ cache */
            $cacheDir = sprintf('%s/%s/%s/', ROOT_PATH, $params->config->app->cachesDir, $params->module);
            if (!is_dir($cacheDir)) { mkdir($cacheDir); } // สร้างโฟล์เดอร์อัตโนมัติ
            
            $view->registerEngines([
                '.phtml' => function ($view, $di) use ($params) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $cachePath = sprintf('%s/%s/%s/', ROOT_PATH, $params->config->app->cachesDir, $params->module);
                    $volt->setOptions([
                        'compiledPath' => function($templatePath) use ($cachePath) {
                            return $cachePath . md5($templatePath) . '.php'; // เข้ารหัส Path
                        },
                        'compiledSeparator' => '_'
                    ]);
                    return $volt;
                },
            ]);
                
            return $view;
            
        });
        
    }
    
    /* ==================================================
     * Security 
     * ================================================== */ 
    
    protected function setSecurity ($manager, $module) {
        
        $manager->set('dispatcher', function () use ($manager, $module) {
            
            $eventsManager = $manager->get('eventsManager');
            $eventsManager->attach('dispatch:beforeExecuteRoute', new \Multiple\Security\SecurityPluginModify($module));
            $eventsManager->attach('dispatch:beforeException', new \Multiple\Security\SecurityPluginModify($module));
            
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace(ucfirst($module) . '\\Controllers');
            
            return $dispatcher;
            
        });
        
    }
    
}