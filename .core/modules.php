<?php

/* ==================================================
 * Register application modules
 * ================================================== */

$addModule = explode(',', $this->config->module->moduleLists);

$modules = [];
foreach ($addModule as $recode) {
    $modules[$recode] = [
        'className' => sprintf('%s\\Module', ucfirst($recode)),
        'path'      => sprintf('%s/modules/%s/Module.php', APP_PATH, $recode),
    ];
}

$this->registerModules($modules);