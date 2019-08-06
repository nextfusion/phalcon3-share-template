<?php

/* =====================================================
 * Auto Loading
 * ===================================================== */

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    sprintf('%s/%s', APP_PATH, $this->config->app->componentsDir),
    sprintf('%s/%s', APP_PATH, $this->config->app->pluginsDir),
    sprintf('%s/%s', APP_PATH, $this->config->app->librarysDir)
])->register();

$loader->registerClasses([
    'Base\\Components\\CModule'     => sprintf('%s/Components/CModule.php', CORE_PATH),
    'Multiple\\Components\\CModule' => sprintf('%s/components/CModule.php', APP_PATH),
]);