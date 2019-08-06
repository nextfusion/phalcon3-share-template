<?php

namespace Multiple\Components;

class CGenerator extends \Base\Components\CComponent {
    
    protected $params        = [];        // parameter
    protected $sourcePath    = 'drivesoft.co.th-sources/tutorial'; // application/source
    protected $fileExtension = 'php';     // .php
    protected $fileDemo      = [ 'demo', 'pExampleBase' ];

    public function __construct ($params = []) {
        
        $pathFile = sprintf('%s/%s/%s.%s', PATH, $this->sourcePath, implode('/', !empty($params) ? $params : $this->fileDemo), $this->fileExtension); 
        
        if (file_exists($pathFile) && is_file($pathFile)) {
            
            try {
                
                $this->params = new \Phalcon\Config\Adapter\Php($pathFile);
                return true;
                
            } catch(\Phalcon\Exception $exc){
                
                unset($exc);
                return false;
                
            } catch (\Exception $exc) {
                
                unset($exc);
                return false;
                
            }
            
        } 
        
        return false;
        
    }   
    
    /* ========================================================
     * Render - อ่านข้อมูลไฟล์
     * ======================================================== */
    
    public function render () {
        return $this->params;
    }
    
    /* ========================================================
     * Generator - สร้างเนื้อหา
     * ======================================================== */
    
    public function getHTML ($html = null) {
        return htmlspecialchars($html);
    }
    
}