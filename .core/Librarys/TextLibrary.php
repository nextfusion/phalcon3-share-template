<?php

/* =====================================================================================
 * TextLibrary.php 
 * Last Update: 2018-02-03 00:00
 * ===================================================================================== */

/* ==================================================================================
 * Code Key:
 * 9   : "\t"
 * 10  : "\n"
 * 32  : เว้นวรรค
 * 40  : "("
 * 41  : ")"
 * 44  : ","
 * 45  : "-"
 * 46  : "."
 * 48  : "0"
 * 57  : "9"
 * 65  : "A"
 * 90  : "Z"
 * 92  : "\"
 * 93  : "["
 * 94  : "]"
 * 95  : "_"
 * 97  : "a"
 * 122 : "z"
 * ================================================================================== */

namespace Base\Librarys;

class TextLibrary extends \Base\Components\CComponent {

    /* ==================================================================================
     * 65 - 90  : "A-Z"
     * 97 - 122 : "a-z"
     * ================================================================================== */

    public function getTextEnglish ($text = null) {

        $str = null;
        $arr = str_split($text);

        foreach ($arr as $value) {
            $key = ord($value);
            if (($key >= 65 && $key <= 90) || ($key >= 97 && $key <= 122)){
                $str .= $value;
            }
        }

        return $str;

    }

    // แสดงจำนวนตัวอักษร (ภาษาอังกฤษ)
    public function getLengthEnglish ($text = null) {
        $arr = str_split($this->getTextEnglish($text));
        return count($arr);
    }

    // แสดงจำนวนตัวอักษร (ภาษาไทย)
    public function getTextThai ($text = null) {

        $str = null;
        $arr = $this->str_split_unicode($text);

        foreach ($arr as $value) {
            $key = ord($value);
            if ($key == 224 || $key == 32) {
                $str .= $value;
            }
        }

        return $str;

    }

    // แสดงจำนวนตัวอักษร (ภาษาไทย)
    public function getLengthThai ($text = null) {
        $arr = $this->str_split_unicode($text);
        return count($arr);
    }

    /* ==================================================================================
     * 48 - 57 : "0-9"
     * ================================================================================== */

    public function getTextNumber ($text = null) {

        $str = null;
        $arr = str_split($text);

        foreach ($arr as $value) {
            $key = ord($value);
            if ($key >= 48 && $key <= 57){
                $str .= $value;
            }
        }

        return $str;

    }

    /* ==================================================================================
     * 
     * ================================================================================== */

    public function str_split_unicode ($str, $l = 0) {
        if ($l > 0) {
            $ret = [];
            $len = mb_strlen($str, 'UTF-8');
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, 'UTF-8');
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
   
}