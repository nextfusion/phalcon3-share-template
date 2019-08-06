<?php

$config = $this->config; // load config

/* ======================================================================
 * Connect MongoDB Database 
 * ====================================================================== */

$manager->set('db1_base', function () use ($config) {
    $db = $config->db1_base;
    if (empty($db->username) || empty($db->password)) {
        $dsn = sprintf('mongodb://%s:%s/%s', $db->host, $db->port, $db->dbname );
    } else {
        $dsn = sprintf('mongodb://%s:%s@%s:%s/%s', $db->username, $db->password, $db->host, $db->port, $db->dbname );
    }
    $mongo = new \Phalcon\Db\Adapter\MongoDB\Client($dsn);
    return $mongo->selectDatabase($db->dbname);
}, true);

/* ======================================================================
 * Connect MySQL Database
 * ====================================================================== */

$manager->set('db2_base', function () use ($config) {
    $db = $config->db2_base;
    return new \Phalcon\Db\Adapter\Pdo\Mysql([
        'host'      => $db->host,
        'port'      => $db->port,
        'username'  => $db->username,
        'password'  => $db->password,
        'dbname'    => $db->dbname,
        'options'   => [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $db->charset ]
    ]);
});

/* ======================================================================
 * Set Custom Parameter
 * ====================================================================== */

$manager->set('ads', function() {
    return new \Multiple\Librarys\AdsLibraryModify();
});