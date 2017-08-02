<?php

namespace Przemyslawdev\News\Models;

use Model;

class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'przemyslawdev_content_news_categories';

    protected $primaryKey = 'id';

    public $hasMany = [
        'news' => 'Przemyslawdev\News\Models\News'
    ];

    public $rules = [
        'name' => 'required|between:4,32',
        'slug' => 'required|between:4,32'
    ];
}
