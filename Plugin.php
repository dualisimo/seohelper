<?php namespace Dualisimo\Seohelper;

use Config;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use System\Classes\CombineAssets;
use Dualisimo\Seohelper\Models\Settings;
use Dualisimo\Seohelper\Classes\Minification;
use Dualisimo\Seohelper\Classes\GeneralSettings;

class Plugin extends PluginBase{

    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    public function pluginDetails(){
        return [
            'name'        => 'SEOHelper',
            'description' => 'Manage Minification, Compression, Cache or Debug mode.',
            'author'      => 'Dualisimo',
            'icon'        => 'icon-thumb-tack'
        ];
    }

    public function registerNavigation(){
        return [
            'minifier' => [
                'label'       => 'SEOHelper',
                'url'         => Backend::url('dualisimo/seohelper/helper/factors'),
                'icon'        => 'icon-lightbulb-o',
                'permissions' => ['*'],
                'order'       => 500,
                'sideMenu' => [
                    'onpage' => [
                        'label' => 'Page Factors',
                        'icon' => 'icon-puzzle-piece',
                        'url' => Backend::url('dualisimo/seohelper/helper/factors')
                    ],
                    'offpage' => [
                        'label' => 'Tips & Tricks',
                        'icon' => 'icon-magic',
                        'url' => Backend::url('dualisimo/seohelper/helper/hints')
                    ]
                ]
            ]
        ];
    }

    public function registerSettings() {
        return [
            'settings' =>  [
                'label'         =>  'SEOHelper',
                'icon'          =>  'icon-thumb-tack',
                'description'   =>  'Manage Minification, Compression, Cache or Debug mode.',
                'class'         =>  'Dualisimo\Seohelper\Models\Settings',
                'order'         =>  500,
                'category'      =>  'Settings',
            ]
        ];
    }

    public function registerComponents() {
        return [
            'Dualisimo\Seohelper\Components\Minifier'  =>  'minifier',
            'Dualisimo\Seohelper\Components\Analyzer'  =>  'analyzer'
        ];
    }

    public function boot(){

        $settings = new GeneralSettings();
        $settings->settings();

        $minifier = new Minification();
        $minifier->minify();

    }
}