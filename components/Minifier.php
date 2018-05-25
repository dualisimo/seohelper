<?php namespace Dualisimo\Seohelper\Components;

use File;
use Config;
use Cms\Classes\Theme;
use Cms\Classes\ComponentBase;
use System\Classes\CombineAssets;
use Dualisimo\Seohelper\Models\Settings;

class Minifier extends ComponentBase{

    public function componentDetails(){
        return [
            'name'        => 'Minifier',
            'description' => 'Inject all your minified and compressed scripts and styles into the pages.'
        ];
    }

    public function defineProperties(){
        return [];
    }

    public function onRun(){
        
        $activeTheme = Config::get('cms.activeTheme');
        $settings = Settings::instance();
        
        $comStatus = $settings->com_status;
        $comJs = $settings->com_js_scripts;
        $comCss = $settings->com_css_scripts;

        if($comStatus){

            $this->comJs($comJs, $activeTheme);
            $this->comCss($comCss, $activeTheme);

        } else{

            $this->comJs($comStatus, $activeTheme);
            $this->comCss($comStatus, $activeTheme);

        }
    }

    function getThemePath($theme, $folder){
        return 'themes/' . $theme . '/assets/' . $folder;
    }

    function comJs($stat, $theme){

        $jsPath = $this->getThemePath($theme, 'javascript');
        $jsFiles = array();
        $jsFilesWithPath = File::files($jsPath);
        $jsFilesCount = count($jsFilesWithPath);

        for ($i = 0; $i < $jsFilesCount; $i++) {
            array_push($jsFiles, basename($jsFilesWithPath[$i]));
        }

        $settings = Settings::instance();
        $minJs = $settings->min_js_scripts;
        $ownJs = $settings->js_own;

        if($ownJs){
            $jsFiles = $this->custom($ownJs, $jsFiles);
        }

        if($stat){
            $this->addJs(CombineAssets::combine($jsFiles, themes_path($theme . '/assets/javascript')));

        } else{

            if($minJs){

                foreach ($jsFiles as $file){
                    $help = array();
                    $help[] = $file;
                    $this->addJs(CombineAssets::combine($help, themes_path($theme . '/assets/javascript')));
                }

            } else {

                foreach ($jsFiles as $file){
                   $this->addJs('/'. $file);
                }
            }
        }
    }

    function comCss($stat, $theme){

        $cssPath = $this->getThemePath($theme, 'css');
        $cssFiles = array();
        $cssFilesWithPath = File::files($cssPath);
        $cssFilesCount = count($cssFilesWithPath);

        for ($i = 0; $i < $cssFilesCount; $i++) {
            array_push($cssFiles, basename($cssFilesWithPath[$i]));
        }

        $settings = Settings::instance();
        $minCss = $settings->min_css_scripts;
        $ownCss = $settings->css_own;

        if($ownCss){
            $cssFiles = $this->custom($ownCss, $cssFiles);
        }

        if($stat){
            $this->addCss(CombineAssets::combine($cssFiles, themes_path($theme . '/assets/css')));

        } else{

            if($minCss){

                foreach ($cssFiles as $file){
                    $help = array();
                    $help[] = $file;
                    $this->addCss(CombineAssets::combine($help, themes_path($theme . '/assets/css')));
                }

            } else {

                foreach ($cssFiles as $file){
                    $this->addCss('/'. $file);
                }
            }
        }
    }

    function custom($custom, $exist){
        
        $delimeter = PHP_EOL;
        $scripts = explode($delimeter, $custom);
        
        $count = 0;
        foreach ($scripts as $item) { $count++; }
        for ($i = 0; $i < $count-1; $i++) {
            $scripts[$i] = substr_replace($scripts[$i], "", -1);
        }
        
        $exist = array_merge($exist, $scripts);
        return $exist;

    }
}