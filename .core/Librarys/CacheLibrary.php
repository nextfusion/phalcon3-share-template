<?php

/* =====================================================================================
 * CacheLibrary.php 
 * Last Update: 2018-02-03 00:00
 * ===================================================================================== */

namespace Base\Librarys;

class CacheLibrary extends \Base\Components\CComponent {
    
    /* ===========================================================
     * Cache 
     * =========================================================== */
    
    public $obj           = null;
    public $content       = null;
    public $cachePath     = null;
    public $cacheDay      = 2; // ระยะเวลาการใช้งานไฟล์ Cache (วัน)
    public $cacheFileType = '.html'; // นามสกุลไฟล์ Cache
    public $cacheDir      = 'runtime/caches/html'; // ไดเรคทอรี่เก็บไฟล์ Cache
    
    public function cacheHTML ($html = null, $realtime = false, $lifetime = null, $filename = null, $cacheDir = null) {

        // จัดเก็บไดเรคทอรี่เก็บไฟล์ Cache
        $_cacheDir = sprintf('%s/%s/%s/', ROOT_PATH, $this->cacheDir, $cacheDir);
        
        // กรณีไม่พบไดเรคทอรี่ ให้ดำเนินการสร้างไดเรคทอรี่ใหม่ (อัตโนมัติ)
        if (!is_dir($_cacheDir)) { mkdir($_cacheDir, 0777); }
        
        // กำหนดระยะเวลาการใช้งานไฟล์ Cache (หมดอายุ)
        $setCache = new \Phalcon\Cache\Frontend\Output([
            'lifetime' => (86400 * !empty($lifetime) ? $lifetime : $this->cacheTime) // 86400 = 24 ชั่วโมง / 1 วัน
        ]);
        
        // กำหนดไดเรคทอรี่เก็บไฟล์ Cache
        $cache = new \Phalcon\Cache\Backend\File($setCache, [ 'cacheDir' => $_cacheDir ]);
        
        // กำหนดชื่อไฟล์ Cache
        $content = $cache->start((!empty($filename) ? $filename : date('Y-m-d-H-i-s', time())) . $this->cacheFileType);
        
        // ตรวจสอบการทำงานแบบ Realtime
        if (empty($realtime)) {
            
            // ตรวจสอบข้อมูลคำสั่ง HTML
            if ($content === null) {
            
                // ไม่พบข้อมูลคำสั่ง HTML
                echo $html;
                $cache->save(); // จัดเก็บไฟล์ Cache

            } else {
                
                // พบข้อมูลคำสั่ง HTML
                echo $content;
                
            }
            
        } else {
            
            // เปิดการทำงานแบบ Realtime
            echo $html;
            
        }
        
    }
    
    public function start ($filename = null, $cacheDir = null) {
        
        // จัดเก็บไดเรคทอรี่เก็บไฟล์ Cache
        $_cacheDir = sprintf('%s/%s/%s/', ROOT_PATH, $this->cacheDir, $cacheDir);

        // กรณีไม่พบไดเรคทอรี่ ให้ดำเนินการสร้างไดเรคทอรี่ใหม่ (อัตโนมัติ)
        if (!is_dir($_cacheDir)) { mkdir($_cacheDir, 0777); }
        
        // กำหนดระยะเวลาการใช้งานไฟล์ Cache (หมดอายุ)
        $setCache = new \Phalcon\Cache\Frontend\Output([
            'lifetime' => (86400 * $this->cacheDay) // 86400 = 24 ชั่วโมง / 30 วัน (ปี)
        ]);
        
        // กำหนดไดเรคทอรี่เก็บไฟล์ Cache
        $this->obj = new \Phalcon\Cache\Backend\File($setCache, [ 'cacheDir' => $_cacheDir ]);
        
        // กำหนดชื่อไฟล์ Cache
        $fileName = (!empty($filename) ? $filename : date('Y-m-d-H-i-s', time())) . $this->cacheFileType;
        $this->cachePath = sprintf('%s/%s', $_cacheDir, $fileName);
        
        // พบไฟล์เดิม
        if ($this->setting->cacheRealtime) {
            if (file_exists($this->cachePath) && is_file($this->cachePath)) { 
                unlink($this->cachePath); 
            }
        }
        
        // เริ่มต้น Cache
        $this->content = $this->obj->start($fileName);
          
    }
    
    public function save () {
        $this->obj->save(); // บันทึก Cache
    }
    
}