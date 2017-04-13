<?php namespace Dual\Seohelper\Models;

use October\Rain\Database\Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'dual_seohelper_settings';

    public $settingsFields = 'fields.yaml';

}