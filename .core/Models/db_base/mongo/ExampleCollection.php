<?php

namespace Base\Models\Mongo;

class ExampleCollection extends \Base\Components\CCollection {
        
    public $row1_example;  // ตัวอย่าง
    public $row2_example;  // ตัวอย่าง
    public $row3_example;  // ตัวอย่าง
        
    /* ===========================================================================
     * SETTING
     * =========================================================================== */

    public function initialize () {
        $this->setConnectionService('db1_base');
    }

    public function getSource () {
        return 'col_example';
    }
    
}