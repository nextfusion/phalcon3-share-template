<?php

namespace Base\Components;

class CCollection extends \Phalcon\Mvc\MongoCollection {

    /* ===========================================================================
     * GET 
     * =========================================================================== */
    
    public function getId() {
        return $this->_id->__toString();
    }

    public static function getDropdownList ($key = null, $attr = null) {
        
        $dropdown = [];
        $model = self::find([ 'conditions' => [ 'status' => 'A' ], 'sort' => [ 'sort' => 1 ] ]);
        
        foreach ($model as $rows) {
            if ($key != '_id') {
                $dropdown[$rows->$key] = $rows->$attr;
            } else {
                $dropdown[$rows->getId()] = $rows->$attr;
            }
        }

        return $dropdown;

    }
    
}