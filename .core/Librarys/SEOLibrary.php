<?php

/* =====================================================================================
 * SEOLibrary.php 
 * Last Update: 2018-02-03 00:00
 * -------------------------------------------------------------------------------------
 * Generator favicon: http://www.favicon-generator.org/
 * ===================================================================================== */

namespace Base\Librarys;

class SEOLibrary extends \Base\Components\CComponent {
    
    private $setting;
    private $pathFavicon     = '/images/favicon';

    private $defaultAuthor   = 'Eakkabin Jaikeawma <eakkabin@drivesoft.co.th>';
    private $defaultSiteName = 'drivesoft dot co dot th';

    public function __construct () {
        $this->setting = new \CSetting();
    }
    
    public function getTitle ($pageTitle = null) {
        return \HTML::tag('title', (!empty($pageTitle) ? $pageTitle . ' | ' : '') . \CSetting::$pageTitle);
    }

    public function getFavicon () {

        $link = null;
        $apple_touch_icon = [ '57', '60', '72', '76', '114', '120', '144', '152', '180' ];

        foreach ($apple_touch_icon as $width) {
            $link .= \HTML::tag('link', $this->url->get(sprintf($this->setCacheVersion($this->pathFavicon . '/apple-icon-%sx%s.png'), $width, $width)), [ 'rel' => 'apple-touch-icon', 'sizes' => sprintf('%sx%s', $width, $width) ]);
        }

        $link .= \HTML::tag('link', $this->url->get($this->setCacheVersion($this->pathFavicon . '/android-icon-192x192.png')), [ 'rel' => 'icon', 'type' => 'image/png', 'sizes' => '192x192' ]);

        $icon = [ '16', '32', '96' ];

        foreach ($icon as $width) {
            $link .= \HTML::tag('link', $this->url->get(sprintf($this->setCacheVersion($this->pathFavicon . '/favicon-%sx%s.png'), $width, $width)), [ 'rel' => 'icon', 'type' => 'image/png', 'sizes' => sprintf('%sx%s', $width, $width) ]);
        }

        $link .= \HTML::tag('link', $this->url->get($this->setCacheVersion($this->pathFavicon . '/favicon-32x32.png')), [ 'rel' => 'shortcut icon', 'type' => 'image/png' ]);
        $link .= \HTML::tag('link', $this->url->get(sprintf($this->setCacheVersion($this->pathFavicon . '/manifest.json'), $width, $width)), [ 'rel' => 'manifest' ]);

        $link .= \HTML::tagCustom('meta', [ 'name' => 'msapplication-TileColor', 'content' => '#ffffff' ]);
        $link .= \HTML::tagCustom('meta', [ 'name' => 'msapplication-TileImage', 'content' => $this->url->get($this->setCacheVersion($this->pathFavicon . '/ms-icon-144x144.png')) ]);
        $link .= \HTML::tagCustom('meta', [ 'name' => 'theme-color', 'content' => '#ffffff' ]);

        return $link;

    }

    public function getProperty ($params = []) {

        list($pageTitle, $pageDescription, $pageKeyword, $pageUrl, $pageImage) = $params;

        $property = null;

        /* Facebook */
        $property .= \HTML::tagCustom('meta', [ 'property' => 'fb:app_id', 'content' => \CSetting::$facebookId ]);

        /* Google SEO */
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:type', 'content' => 'website' ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:locale', 'content' => \CSetting::$facebookLocale ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:title', 'content' => (!empty($pageTitle) ? $pageTitle . ' | ' : '') . \CSetting::$pageTitle ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:description', 'content' => (!empty($pageDescription) ? $pageDescription . ' | ' : '') . \CSetting::$pageDescription ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:url', 'content' => (!empty($pageUrl) ? $this->url->get($pageUrl) : $this->url->get(\CSetting::$pageUrl)) ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:site_name', 'content' => $this->defaultSiteName ]);
        $property .= \HTML::tagCustom('meta', [ 'property' => 'og:image', 'content' => (!empty($pageImage) ? $this->url->get($pageImage) : $this->url->get(\CSetting::$pageImage)) ]);

        /* SEO */
        $property .= \HTML::tagCustom('meta', [ 'name' => 'keywords', 'content' => implode(',', array_merge(!empty($pageKeyword) ? $pageKeyword : [], \CSetting::$pageKeyword)) ]);
        $property .= \HTML::tagCustom('meta', [ 'name' => 'description', 'content' => (!empty($pageDescription) ? $pageDescription . ' | ' : '') . \CSetting::$pageDescription ]);
        $property .= \HTML::tagCustom('meta', [ 'name' => 'author', 'content' => !empty(\CSetting::$pageAuthor) ? \CSetting::$pageAuthor : $this->defaultAuthor ]);

        return $property;

    }

    public function getGoogleAnalysis () {

        if (ENV_MODE === true || \CSetting::$googleAnalysisId == false) { return null; }

        return '<script>
            (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
            ga("create", "' . \CSetting::$googleAnalysisId . '", "auto");
            ga("send", "pageview");
        </script>';

    }

    public function setCacheVersion ($file = null) {
        return $file . \CSetting::$cacheVersion;
    }

    protected function getValue ($data = []) {
        echo '<meta charset="utf-8"><pre>'; print_r($data); echo '</pre>'; exit();
    }
    
}