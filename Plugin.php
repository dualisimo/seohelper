<?php namespace Dual\Seohelper;

use Config;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use System\Classes\CombineAssets;
use Dual\Seohelper\Models\Settings;
use Dual\Seohelper\Classes\Minifier;

class Plugin extends PluginBase{

    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    public function pluginDetails(){
        return [
            'name'        => 'SEOHelper',
            'description' => 'Sometimes less is more.',
            'author'      => 'Dual',
            'icon'        => 'icon-thumb-tack'
        ];
    }

    public function registerNavigation(){
        return [
            'minifier' => [
                'label'       => 'SEOHelper',
                'url'         => Backend::url('dual/seohelper/helper/factors'),
                'icon'        => 'icon-lightbulb-o',
                'permissions' => ['*'],
                'order'       => 500,
                'sideMenu' => [
                    'onpage' => [
                        'label' => 'Page Factors',
                        'icon' => 'icon-puzzle-piece',
                        'url' => Backend::url('dual/seohelper/helper/factors')
                    ],
                    'offpage' => [
                        'label' => 'Tips & Tricks',
                        'icon' => 'icon-magic',
                        'url' => Backend::url('dual/seohelper/helper/hints')
                    ]
                ]
            ]
        ];
    }

    public function registerSettings() {
        return [
            'settings' =>  [
                'label'         =>  'Injector',
                'icon'          =>  'icon-thumb-tack',
                'description'   =>  'Settings for minify JS and CSS code in a head of default template.',
                'class'         =>  'Dual\Seohelper\Models\Settings',
                'order'         =>  500,
                'category'      => 'SEOHelper',
            ]
        ];
    }

    public function registerComponents() {
        return [
            'Dual\Seohelper\Components\Inject'  =>  'injector'
        ];
    }

    public function boot(){

        $minifier = new Minifier();
        $minifier->minify();

    }
}