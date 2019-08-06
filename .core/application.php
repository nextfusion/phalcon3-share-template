<?php

/* ==================================================
 * Environment
 * ================================================== */

define('ENV_MODE', true);
define('PHALCON_DEBUG', true);

date_default_timezone_set('Asia/Bangkok');

if (ENV_MODE === true) {
    error_reporting(-1);
    ini_set('display_errors', 1);
} else if (ENV_MODE === false) {
    error_reporting(0); 
    ini_set('display_errors', 'On');
}

class Application extends \Phalcon\Mvc\Application {
    
    private $config;
    private $manager;
    
    public function __construct () {

        if (ENV_MODE === true) {
            $this->config = new \Phalcon\Config\Adapter\Ini(__DIR__ . '/Commons/client.ini');
            $this->config->merge(new \Phalcon\Config\Adapter\Ini(APP_PATH . '/commons/client/config.ini'));
        } else {
            $this->config = new \Phalcon\Config\Adapter\Ini(__DIR__ . '/Commons/server.ini');
            $this->config>merge(new \Phalcon\Config\Adapter\Ini(APP_PATH . '/commons/server/config.ini'));
        }

    }
    
    private function _registerServices () {

        $debug = new \Phalcon\Debug();
        $debug->listen(PHALCON_DEBUG);

        $this->manager = new \Phalcon\DI\FactoryDefault();

        $this->include_file('autoloader.php', __DIR__); // autoload directory    
        $this->include_file('commons/autoloader.php', APP_PATH); // autoload directory
        $this->include_file('routers.php', __DIR__); // router
        $this->setDI($this->manager);

    }
    
    public function run () { 

        try { 

            $this->_registerServices(); 
            $this->include_file('modules.php', __DIR__); // load modules
            echo $this->handle(!empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : null)->getContent(); exit;

        } catch (\Phalcon\Exception $e) {

            if (ENV_MODE === true) {
                echo 'PhalconException: ' . $e->getMessage(); exit;
            } else {
                header(sprintf('Location: %s/404.html', $this->config->app->baseUri)); exit;
            }

        } catch (\Exception $e) {

            if (ENV_MODE === true) {
                echo 'PhpException: ' . $e->getMessage(); exit;
            } else {
                header(sprintf('Location: %s/404.html', $this->config->app->baseUri)); exit;
            }

        }

    }
    
    public function include_file ($file = null, $path = null) {

        $pathFile = sprintf('%s/%s', $path, $file);

        if (!empty($pathFile) && file_exists($pathFile)) {
            $manager = $this->manager;
            include_once $pathFile;
            $this->manager = $manager;
        }

        return false;
        
    }
    
}