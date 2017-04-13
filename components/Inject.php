<?php namespace Dualisimo\Seohelper\Components;

use File;
use Config;
use Response;
use Cms\Classes\Theme;
use Cms\Classes\ComponentBase;
use System\Classes\CombineAssets;
use Dualisimo\Seohelper\Models\Settings;

class Inject extends ComponentBase{

    public function componentDetails(){
        return [
            'name'        => 'Injector',
            'description' => 'Inject your minify and compress all scripts and styles.'
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

        $anaStatus = $settings->ana_status;
        $anaCode = $settings->ana_code;
        $anaOld = $settings->ana_old;

        if($comStatus){

            $this->comJs($comJs, $activeTheme);
            $this->comCss($comCss, $activeTheme);

        } else{

            $this->comJs($comStatus, $activeTheme);
            $this->comCss($comStatus, $activeTheme);

        }

        if($anaStatus && $anaCode != null){
            $this->anaJS($anaCode, $anaOld);
        }

        $this->page['ana'] = $anaStatus;
        
    }

    function comJs($stat, $theme){

        $jsPath = 'themes/' . $theme . '/assets/javascript';
        $jsFiles = File::files($jsPath);

        $settings = Settings::instance();
        $minJs = $settings->min_js_scripts;
        $ownJs = $settings->js_own;

        if($ownJs){
            $jsFiles = $this->custom($ownJs, $jsFiles);
        }

        if($stat){
            $this->addJs(CombineAssets::combine($jsFiles, base_path('/')));

        } else{

            if($minJs){

                foreach ($jsFiles as $file){
                    $help = array();
                    $help[] = $file;
                    $this->addJs(CombineAssets::combine($help, base_path('/')));
                }

            } else {

                foreach ($jsFiles as $file){
                   $this->addJs('/'. $file);
                }
            }
        }
    }

    function comCss($stat, $theme){

        $cssPath = 'themes/' . $theme . '/assets/css';
        $cssFiles = File::files($cssPath);

        $settings = Settings::instance();
        $minCss = $settings->min_css_scripts;
        $ownCss = $settings->css_own;

        if($ownCss){
            $cssFiles = $this->custom($ownCss, $cssFiles);
        }

        if($stat){
            $this->addCss(CombineAssets::combine($cssFiles, base_path('/')));

        } else{

            if($minCss){

                foreach ($cssFiles as $file){
                    $help = array();
                    $help[] = $file;
                    $this->addCss(CombineAssets::combine($help, base_path('/')));
                }

            } else {

                foreach ($cssFiles as $file){
                    $this->addCss('/'. $file);
                }
            }
        }
    }

    function anaJS($id, $old){

        $anaPath = 'plugins/dualisimo/seohelper/components/inject/default-analytics.htm';
        $anaFile = File::get($anaPath);
        $anaFile = str_replace("§code§", $id, $anaFile);
        $pathExist = 'plugins/dualisimo/seohelper/components/inject/analytics.htm';

        if($old == null){

            File::put($pathExist, $anaFile);
            Settings::set('ana_old', $id);
        } else{

            if($old != $id){

                File::delete($pathExist);
                File::put($pathExist, $anaFile);
                Settings::set('ana_old', $id);
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