<?php namespace Dualisimo\Seohelper\Classes;

use Config;
use System\Classes\CombineAssets;
use Dualisimo\Seohelper\Models\Settings;

class GeneralSettings{

	public function init(){

        $settings = Settings::instance();
        $debugStatus = $settings->debug_status;
        $cacheStatus = $settings->cache_status;

        $this->debug($debugStatus);
        $this->cache($cacheStatus);
    }

    public function debug($stat){
        if($stat){
            if(empty(Config::get('app.debug'))){
                Config::set('app.debug', true);
            }
        } else{
            if(!empty(Config::get('app.debug'))){
               Config::set('app.debug', false);
            } 
        }
    }

    public function cache($stat){
        if($stat){
            if(empty(Config::get('cms.enableAssetCache'))){
                Config::set('cms.enableAssetCache', true);
            }
        } else{
            if(!empty(Config::get('cms.enableAssetCache'))){
               Config::set('cms.enableAssetCache', false);
            } 
        }
    }
}