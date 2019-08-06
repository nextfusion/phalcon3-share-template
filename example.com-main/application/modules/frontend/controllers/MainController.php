<?php

namespace Frontend\Controllers;

class MainController extends \Frontend\Controllers\CController {

    public function initialize () {
        parent::initialize();
    }
    
    public function indexAction () {
        $this->setAssetsBase();
    }

}