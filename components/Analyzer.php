<?php namespace Dualisimo\Seohelper\Components;

use File;
use Cms\Classes\ComponentBase;
use Dualisimo\Seohelper\Models\Settings;

class Analyzer extends ComponentBase{

    public function componentDetails(){
        return [
            'name'        => 'Analyzer',
            'description' => 'Inject tracking Google Analytics script with your ID into the page.'
        ];
    }

    public function defineProperties(){
        return [];
    }

    public function onRun(){
        
        $settings = Settings::instance();

        $anaStatus = $settings->ana_status;
        $anaCode = $settings->ana_code;
        $anaOld = $settings->ana_old;

        if($anaStatus && $anaCode != null){
            $this->anaJS($anaCode, $anaOld);
        }

        $this->page['ana'] = $anaStatus;
        
    }

    function anaJS($id, $old){

        $anaPath = 'plugins/dualisimo/seohelper/components/analyzer/default-analytics.htm';
        $anaFile = File::get($anaPath);
        $anaFile = str_replace("§code§", $id, $anaFile);
        $pathExist = 'plugins/dualisimo/seohelper/components/analyzer/analytics.htm';

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
}