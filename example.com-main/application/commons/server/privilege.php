<?php

return [
    
    'roleDefault'  => 'Guest',
    
    'roles' => [
        'owner'   => 'Owner',   // ผู้บริหาร
        'admin'   => 'Admin',   // ผู้ดูแลระบบ
        'manager' => 'Manager', // ผู้จัดการ
        'member'  => 'Member',  // สมาชิก
        'vip'     => 'Vip',     // สมาชิก (พิเศษ)
        'guest'   => 'Guest',   // ผู้ใช้ทั่วไป
    ],

    'resource' => [
        /*
        'example' => [
            'Guest' => [
                'main' => [ 'index' ],
            ],
        ],
        */
        'frontend' => [
            'Guest' => [
                'main'   => [ 'index' ],
            ],
            'Member' => [
                'main'   => [ 'index' ],
            ],
            'Admin' => [
                'main'   => [ 'index' ],
            ],
        ],
        /*
        'moduleName' => [
            'roleName' => [
                'controllerName' => [ 'actionName', 'actionName', 'actionName' ],
                'controllerName' => [ 'actionName', 'actionName', 'actionName' ],
            ],
        ],
        */
    ],

    'resourceError' => [ 'route401', 'route404', 'route500' ],
    
];