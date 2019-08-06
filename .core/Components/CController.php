<?php

namespace Base\Components;

class CController extends \Phalcon\Mvc\Controller {
    
    public $pageTitle       = null; 
    public $pageDescription = null; 

    public function initialize () {
        
        $this->view->setVars([
            'pageTitle'       => $this->pageTitle,
            'pageDescription' => $this->pageDescription,
            'pageImage'       => \CSetting::$pageImage,
            'pageKeyword'     => [],
            'pageUrl'         => $this->url->get('')
        ]);

        $this->assets->collection('cssHeader');
        $this->assets->collection('cssFooter');
        $this->assets->collection('jsFooter');
        $this->assets->collection('jsHeader');
        
        $this->setLayout('partials/main');
        
    }
    
    /* เรียกใช้งาน Assets Manager */
    protected function setAssetsBase () {
        
        /* 

        * =========================================================
        * Example
        * =========================================================

        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('vendor/font-awesome/4.6.3/css/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false);
        
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('vendor/jquery/2.1.4/jquery.min.js'));
        
        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('vendor/font-awesome/4.6.3/css/font-awesome.min.css'));
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('assets/script/scrolltopcontrol.min.js));
         
        */
        
    }
    
    /* Theme */
    protected function setTheme ($theme = null) {
        $this->view->setLayoutsDir(sprintf('%s/%s/', $this->config->theme->themesDir, $theme));
    }
    
    /* Layout */
    protected function setLayout ($layout = null) {
        $this->view->setTemplateAfter(sprintf('layouts/%s', $layout));
    }
   
    /* Assets */
    protected function getPathAssets ($path = null) {
        return $path . '?v=' . \CSetting::$version;
    }
    
}