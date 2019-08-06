<?php

namespace Frontend\Controllers;

class CController extends \Multiple\Components\CController {

    public $pageTitle       = null;
    public $pageDescription = null; 
    
    public function initialize () {
        parent::initialize();
    }
    
    protected function setAssetsBase () {
        parent::setAssetsBase();
    }
  
}