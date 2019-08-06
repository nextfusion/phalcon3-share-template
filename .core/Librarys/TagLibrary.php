<?php

/* =====================================================================================
 * TagLibrary.php 
 * Last Update: 2018-02-03 00:00
 * ===================================================================================== */

namespace Base\Librarys;

class TagLibrary extends \Base\Components\CComponent {
    
    private $tags    = [];
    private $keyword = null;
    
    public function __construct ($keyword = null) {
        
        $this->keyword = $keyword;
        $this->formatString($keyword);
        
    }

    private function formatString ($keyword = null) {
        $tags = explode(',', $keyword);
        foreach ($tags as $key => $value) {
            $tags[$key] = $this->removeTag($value);
        }
        $this->tags = $tags;
    }
    
    private function removeTag ($string = null) {
        $str = '';
        $arr = str_split($string);
        foreach ($arr as $value) {
            $key = ord($value);
            if ($key == 45 || ($key >= 48 && $key <= 57) || ($key >= 65 && $key <= 90) || ($key >= 97 && $key <= 122)){
                $str .= $value;
            }
        }
        return $str;
    }
    
    public function get () {
        return $this->tags;
    }
    
}