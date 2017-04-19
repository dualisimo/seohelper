<?php namespace Dualisimo\Seohelper\Classes;

use Config;
use Dualisimo\Seohelper\Models\Settings;

class GeneralSettings{

	public function settings(){

        $settings = Settings::instance();
        $debugStatus = $settings->debug_status;
        $cacheStatus = $settings->cache_status;

        $this->debug($debugStatus);
        $this->cache($cacheStatus);
    }

    public function debug($stat){
        if($stat){
            Config::set('app.debug', true);
        } elseif($stat == null){
            Settings::set('debug_status', 1);
        } else{
            Config::set('app.debug', false);
        }
    }

    public function cache($stat){
        if($stat){
            Config::set('cms.enableAssetCache', true);
        } else{
            Config::set('cms.enableAssetCache', false);
        }
    }
}