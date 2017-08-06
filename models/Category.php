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
        'name' => 'required|unique:przemyslawdev_content_news_categories|between:4,32',
        'slug' => 'required|unique:przemyslawdev_content_news_categories|between:4,32'
    ];

    public function scopeSlug($query, $value)
    {
        $query->where('slug', $value);
    }
}
