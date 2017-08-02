<?php

namespace Przemyslawdev\News\Models;

use Model;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'newsletter_template_count' => 'required',
    ];

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'przemyslawdev_news_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
