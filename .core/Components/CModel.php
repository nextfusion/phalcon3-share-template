<?php

namespace Base\Components;

class CModel extends \Phalcon\Mvc\Model {
    
    /*
    public function getAutoID($str = null, $number = 1, $last_id = null){
        
        if (empty($str)) { return false; }
        
        // Example. ORD59010001
        $year_now   = substr((date('Y', time()) + 543), 2, 2); // 59 = 2559
        $month_now  = date('m', time());                       // 01 = มกราคม

        if (!empty($last_id)) {

            // Example. ORD59010001
            // Index.   01234567890
            
            $year_last   = intval(substr($last_id, 3, 2)); // 59
            $month_last  = intval(substr($last_id, 5, 2)); // 01
            $number_last = intval(substr($last_id, 7, 4)); // 0001
            
            if ($year_now == $year_last) {
                if ($month_now == $month_last) {
                    $number = ($number_last + 1);
                }
            }
            
        }
        
        // Example. ORD59010001
        return $str . $year_now . str_pad($month_now, 2, '0', STR_PAD_LEFT) . str_pad($number, 4, '0', STR_PAD_LEFT);
                    
    }
    */
    
}