<?php

class CWidget extends \Phalcon\Mvc\User\Component {
    
    public function getWidget ($widget = null) {
        
        $replace = str_replace('.', '\\', $widget);
        $class = sprintf('Multiple\\Widgets\\%s', ucfirst($replace));
        
        if (class_exists($class)) {
            $objClass = new $class;
            if (method_exists($objClass, 'init')) {
                $objClass->init();
            }
            return $objClass;
        }
        
        return false;
        
    }
    
}