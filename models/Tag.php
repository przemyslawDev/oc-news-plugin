<?php

namespace Przemyslawdev\News\Models;

use Model;

class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'przemyslawdev_content_news_tags';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    public $belongsToMany = [
        'news' => [
            'Przemyslawdev\News\Models\News',
            'table' => 'przemyslawdev_content_news_news_tags'
        ]
    ];

    public $rules = [
        'name' => 'required|between:4,32'
    ];

    public $attributeNames = [
        'name' => 'Tag name'
    ];
}
