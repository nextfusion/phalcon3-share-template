<?php

namespace Example\Controllers;

class CController extends \Multiple\Components\CController {

    public $pageTitle = 'HOME';
    
    public function initialize () {
        parent::initialize();
    }
    
    public function setAssetsBase () {
        parent::setAssetsBase();
    }
    
}