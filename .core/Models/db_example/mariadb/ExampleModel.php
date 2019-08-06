<?php

namespace Example\Models\Maria;

class ExampleModel extends \Base\Components\CModel {
    
    public $field1_example;  // ตัวอย่าง
    public $field2_example;  // ตัวอย่าง
    public $field3_example;  // ตัวอย่าง
    
    /* ===========================================================================
     * SETTING
     * =========================================================================== */
 
    public function initialize () {
        $this->setConnectionService('db2_example');
    }

    public function getSource () {
        return 'tbl_example';
    }
    
}