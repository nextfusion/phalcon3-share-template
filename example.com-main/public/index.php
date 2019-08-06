<?php

/* ==================================================
 * Default Directory
 * ================================================== */

if (!defined('ROOT_PATH')) {
    define('PATH', dirname(dirname(dirname(__FILE__))));
    define('ROOT_PATH', dirname(dirname(__FILE__)));
    define('CORE_PATH', sprintf('%s/.core', dirname(dirname(dirname(__FILE__)))));
    define('APP_PATH',  sprintf('%s/application', ROOT_PATH));
    define('IMG_PATH',  sprintf('%s/public/images', ROOT_PATH));
}

/* ==================================================
 * Web Application
 * ================================================== */

include_once (sprintf('%s/application.php', CORE_PATH));

$application = new Application();
$application->run();