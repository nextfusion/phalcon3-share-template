<?php

namespace Base\Components;

class CSetting extends \Phalcon\Mvc\User\Component {
    
    /* ===========================================================
     * Access Control List (ACL)
     * =========================================================== */
    
    public $securityEnabled  = true; // เปิดโหมด ACL นี้
    public $securityRealtime = true; // อัพเดทตลอดเวลา
 
    /* ===========================================================
     * Cache
     * =========================================================== */
    
    public $cacheRealtime = true; // dev = true, prod = false
    
}