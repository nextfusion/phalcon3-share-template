<?php

/* =====================================================================================
 * DateLibrary.php 
 * Last Update: 2018-02-03 00:00
 * ===================================================================================== */

class DateLibrary extends \Phalcon\Mvc\User\Component {
    
    private static $thDay = [ 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์' ];
    private static $thMonth = [ '0' => '', '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม' ];
    
    /* ==============================================================================================
     * เกี่ยวกับ วันที่ / เวลา
     * ============================================================================================== */
    
    // output: อาทิตย์ที่ 01 ธันวาคม พ.ศ. 2556 เวลา 14:51:35 น.
    public static function thai_full ($_time = null) {
        if (!empty($_time)) {
            $time = strtotime($_time);
        } else {
            $time = time(); // ปัจจุบัน
        }
        return sprintf('%sที่ %d %s พ.ศ. %d เวลา %s น.', self::$thDay[date('w', $time)], date('d', $time), self::$thMonth[date('m', $time)], (date('Y', $time) + 543), date('H:i:s', $time));
    }
    
    // output: 01 ธันวาคม 2556 เวลา 14:51:35 น.
    public static function thai_datetime ($_time = null) {
        if (!empty($_time)) {
            $time = strtotime($_time); 
        } else {
            $time = time(); // ปัจจุบัน
        }
        return sprintf('%d %s %d เวลา %s น.', date('d', $time), self::$thMonth[date('m', $time)], (date('Y', $time) + 543), date('H:i:s', $time));
    } 
    
    // output: อาทิตย์ที่ 01 ธันวาคม พ.ศ. 2556
    public static function thai_date ($_time) {
        if (!empty($_time)) {
            $time = strtotime($_time); 
        } else {
            $time = time(); // ปัจจุบัน
        }
        return sprintf('%d %s พ.ศ. %d', date('d', $time), self::$thMonth[date('m', $time)], (date('Y', $time) + 543));
    } 
    
    // output: ธันวาคม
    public static function thai_month ($_time) {
        if (!empty($_time)) {
            $time = strtotime($_time); 
        } else {
            $time = time(); // ปัจจุบัน
        }
        return self::$thMonth[date('m', $time)];
    } 
    
    // output: 2559
    public static function thai_year ($_time) {
        if (!empty($_time)) {
            $time = strtotime($_time); 
        } else {
            $time = time(); // ปัจจุบัน
        }
        return (date('Y', $time) + 543);
    }
    
    // output: เวลา 14:51:35 น.
    public static function thai_time ($_time) {
        if (!empty($_time)) {
            $time = strtotime($_time); 
        } else {
            $time = time(); // ปัจจุบัน
        }
        return sprintf('เวลา %d น.', date('H:i:s', $time));
    }
    
    // output: 2016-12-01 14:51:35
    public static function date ($format = null) {
        if(!empty($format)) {
            return date($format, time());
        } else {
            return date('Y-m-d H:i:s', time()); 
        }
    }
    
}