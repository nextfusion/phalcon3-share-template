<?php

$config = $this->config;

/* ======================================================================
 * Base URL
 * ====================================================================== */

$manager->set('url', function () use ($config) {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->app->baseUri);
    return $url;
}, true);

/* ======================================================================
 * Connect MongoDB Database 
 * ====================================================================== */

$manager->set('collectionManager', function() {
    return new \Phalcon\Mvc\Collection\Manager();
}, true);

/* ======================================================================
 * Set Parameter
 * ====================================================================== */

$manager->set('config', function () use ($config) {
    return $config;
}, true);

$manager->set('logger', function () use ($config) {
    $monthNow = date('Y-m-d', time());
    $pathLog = sprintf('%s/%s/%s/%s.log', APP_PATH, $config->app->logsDir, $this->moduleName, $monthNow); 
    return new LogFile($pathLog);
});

$manager->set('modelsMetadata', function () {
    return new \Phalcon\Mvc\Model\Metadata\Memory();
});

$manager->set('session', function () {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});

$manager->set('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);
    return $cookies;
});

$manager->set('crypt',
    function () {
        $crypt = new \Phalcon\Crypt();
        $crypt->setKey('#1dj8$=dp?.ak//j1V$');
        return $crypt;
    }
);

$manager->set('flash', function () { 
    return new \Phalcon\Flash\Direct([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

$manager->set('flashSession', function () {
    return new \Phalcon\Flash\Session();
});

/* ======================================================================
 * Set Custom Parameter
 * ====================================================================== */

$manager->set('setting', function() {
    return new \CSetting();
});

$manager->set('auth', function() {
    return new \Base\Components\CAuth();
});

$manager->set('cache', function() {
    return new \Base\Librarys\CacheLibrary();
});

$manager->set('seo', function() {
    return new \Base\Librarys\SEOLibrary();
});