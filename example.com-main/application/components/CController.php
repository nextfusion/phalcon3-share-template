<?php

namespace Multiple\Components;

class CController extends \Base\Components\CController {

    public function initialize () {
        parent::initialize();
        $this->setLayout('partials/main');
    }
    
    protected function setAssetsBase () {

        $this->assets->collection('cssHeader')->addCss($this->getPathAssets('/themes/main/styles/theme-main.min.css'));
            
        /* 
         
        * =========================================================
        * Example
        * =========================================================

        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('//vendor.drivesoft.co.th/font-awesome/4.6.3/css/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false);
        
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('//vendor.drivesoft.co.th/jquery/2.1.4/jquery.min.js'));
        
        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('//vendor.drivesoft.co.th/font-awesome/4.6.3/css/font-awesome.min.css'));
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/assets/script/scrolltopcontrol.min.js));
         
        */
        
    }
    
}