<?php namespace Dual\Seohelper\Classes;

use Config;
use System\Classes\CombineAssets;
use Dual\Seohelper\Models\Settings;

class Minifier{

	public function minify(){

        $settings = Settings::instance();
        $minStatus = $settings->min_status;
        $minJs = $settings->min_js_scripts;
        $minCss = $settings->min_css_scripts;

        if($minStatus){
            $this->minJs($minJs);
            $this->minCss($minCss);
        } else{
            $this->minJs($minStatus);
            $this->minCss($minStatus);
        }
    }

	public function minJs($stat){

		if($stat){
	        $combine = CombineAssets::instance();
        	$combine->registerFilter('js', new \Assetic\Filter\JSMinFilter);
        } else {
        	$this->disableMinification();
        }
	}

	public function minCss($stat){

		if($stat){
	        $combine = CombineAssets::instance();
        	$combine->registerFilter(['css', 'less', 'scss'], new \October\Rain\Parse\Assetic\StylesheetMinify);
        } else {
        	$this->disableMinification();
        }
	}

	public function disableMinification(){
		
		Config::set('cms.enableAssetMinify', false);
	}
}