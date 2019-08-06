<?php

/* =====================================================================================
 * HTML.php 
 * Last Update: 2018-02-03 00:00
 * ===================================================================================== */

class HTML extends \Phalcon\Mvc\User\Component {
    
    private static $cacheVersion = '0.0.1';
    private static $imgDefault = 'default.png';

    public static function image ($path = null, $htmlOptions = [ 'alt' => 'images' ]) {

        $pathImage = sprintf('%s/%s', IMG_PATH, $path);

        if (file_exists($pathImage) && !is_dir($pathImage)) {
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            $htmlOption = array_merge([ 'width' => $width, 'height' => $height ], $htmlOptions);
            return HTML::tag('img', \CSetting::$urlImage . $path . HTML::getFileCache(), $htmlOption);
        } else {
            return self::imageDefault($htmlOptions); // ไม่พบไฟล์
        } 

    } 
    
    public static function imageUrl ($path = null) {

        $pathImage = sprintf('%s/%s', IMG_PATH, $path);

        if (file_exists($pathImage) && !is_dir($pathImage)) {
            return \CSetting::$urlImage . $path . HTML::getFileCache();
        } else {
            return self::imageUrlDefault(); // ไม่พบไฟล์
        }
        
    }
    
    public static function imageDefault ($htmlOptions = [ 'alt' => 'images' ]) {

        $pathImage = sprintf('%s/%s', IMG_PATH, self::$imgDefault);

        if (file_exists($pathImage) && !is_dir($pathImage)) {
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            $htmlOption = array_merge([ 'width' => $width, 'height' => $height ], $htmlOptions);
            return HTML::tag('img', \CSetting::$urlImage . self::$imgDefault . \HTML::getFileCache(), $htmlOption);
        }

    }
    
    public static function imageUrlDefault () {

        $pathImage = sprintf('%s/%s', IMG_PATH, self::$imgDefault);

        if (file_exists($pathImage) && !is_dir($pathImage)) {
            list($width, $height) = getimagesize($pathImage); // พบไฟล์
            return HTML::tag('img', \CSetting::$urlImage . self::$imgDefault . \HTML::getFileCache(), [ 'width' => $width, 'height' => $height ]);
        }

    }
    
    public static function getFileCache () {

        if (!empty(\CSetting::$cacheVersion)) { 
            return \CSetting::$cacheVersion; 
        } else { 
            return '?v=' . \HTML::$cacheVersion;
        }

    }

    public static function tag ($tag = null, $content = null, $htmlOptions = []) {

        if (!empty($tag)) {
            if ($tag == 'img' || $tag == 'input') {
                return sprintf('<%s src="%s" %s />', $tag, $content, HTML::tagOptions($htmlOptions));
            } else if ($tag == 'link') {
                return sprintf('<%s href="%s" %s />', $tag, $content, HTML::tagOptions($htmlOptions));    
            } else {
                return sprintf('<%s %s>%s</%s>', $tag, HTML::tagOptions($htmlOptions), $content, $tag);
            }
        } else { return false; }

    }

    public static function tagCustom ($tag = null, $htmlOptions = []) {

        if (!empty($tag)) {
            if ($tag == 'meta') { 
                return sprintf('<%s %s />', $tag, HTML::tagOptions($htmlOptions)); 
            } else { 
                return sprintf('<%s %s>%s</%s>', $tag, HTML::tagOptions($htmlOptions), $tag); 
            }
        } else { return false; }

    }

    public static function tagOptions ($htmlOptions = []) {

        if (!empty($htmlOptions)) {
            $attribute = '';
            foreach ($htmlOptions as $property => $value) {
                if (!empty($value)) { $attribute .= sprintf(' %s="%s"', $property, $value); }
            }
            return $attribute;
        }

    }
    
    /* =======================================================
     * Link
     * ======================================================= */
    
    public static function serachLink ($content = null, $htmlOptions = []) {

        if (!empty($content)) {

            $linkTag = self::serachLinkSytex($content);

            if (!empty($linkTag)) {

                if (!empty($htmlOptions)) {
                    $replace = self::tag('a', trim($linkTag['text']), array_merge( [ 'href' => $linkTag['link'], 'target' => '_blank' ], $htmlOptions));
                } else {
                    $replace = self::tag('a', trim($linkTag['text']), [ 'href' => $linkTag['link'], 'target' => '_blank' ]);
                }

                $html = str_replace($linkTag['search'], $replace, $content);
                unset($linkTag); unset($replace); unset($content);

                if (!empty(self::serachLinkSytex($html))) { return self::serachLink($html, $htmlOptions); } 
                else { unset($content); return $html; }

            } 
            
            else { return $content; }

        }

    }
    
    private static function serachLinkSytex ($content = null) {

        $start = strpos($content,'[');   // ค้นหาตำแหน่งของ "["
        $end   = strpos($content,']');   // ค้นหาตำแหน่งของ "]"
        $and   = strpos($content,'||');  // ค้นหาตำแหน่งของ "||"

        if (!empty($start) && !empty($end) && !empty($and)) {

            $search = substr($content, $start, ($end - $start) + 1);
            $link = substr($content, ($start + 1), ($and - $start) - 1);
            $text = substr($content, ($and + 2), ($end - $and) - 2);
            unset($start); unset($end); unset($and); unset($content);

            return [ 'search' => $search, 'link' => $link, 'text' => $text ];

        } else if (!empty($start) && !empty($end) && empty($and)) {

            $search = substr($content, $start, ($end - $start) + 1);
            $link = substr($content, ($start + 1), ($end - $start) - 1);
            unset($start); unset($end); unset($content);

            return [ 'search' => $search, 'link' => $link, 'text' => $link ];

        } 
        
        else { unset($content); return false; }

    }
    
}