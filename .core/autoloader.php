<?php

/* =====================================================
 * Auto Loading
 * ===================================================== */

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    sprintf('%s/%s', CORE_PATH, 'Components'),
    sprintf('%s/%s', CORE_PATH, 'Librarys'),
    sprintf('%s/%s', CORE_PATH, 'Security')
])->register();

/* =====================================================
 * Custom Method
 * ===================================================== */

function getValue ($data = []) { echo '<meta charset="utf-8"><pre>'; print_r($data); echo '</pre>'; exit(); }