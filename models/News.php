<?php

namespace Przemyslawdev\News\Models;

use Backend\Facades\BackendAuth;
use Carbon\Carbon;
use Model;
use Przemyslawdev\News\Classes\NewsSender;

class News extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'przemyslawdev_content_news_news';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'summary',
        'content',
        'image',
        'published_at',
        'newsletter_send'
    ];

    protected $dates = ['published_at'];

    public $belongsTo = [
        'category' => 'Przemyslawdev\News\Models\Category',
        'user' => ['Backend\Models\User', 'id', 'user_id']
    ];

    public $belongsToMany = [
        'tags' => ['Przemyslawdev\News\Models\Tag', 'table' => 'przemyslawdev_content_news_news_tags']
    ];

    public $rules = [
        'title' => 'required|unique:przemyslawdev_content_news_news|between:4,32',
        'slug' => 'required|unique:przemyslawdev_content_news_news|max:12',
        'category' => 'required',
        'summary' => 'required',
        'content' => 'required',
        'published_at' => 'required|date|after:yesterday'
    ];

    public static $allowedSorting = [
        'title asc',
        'title desc',
        'created_at asc',
        'created_at desc',
        'updated_at asc',
        'updated_at desc',
        'published_at asc',
        'published_at desc'
    ];

    public function scopeListFrontend($query, $options)
    {
        extract(array_merge([
            'perPage' => 10,
            'sortOrder' => 'published_at desc',
            'category' => 'all',
            'featured' => 0
        ], $options));

        if ($category !== 'all') {
            $query->categorySlug($category);
        }

        if ($featured != 0) {
            $query->isFeatured($featured);
        }

        if (!is_array($sortOrder)) {
            $sortOrder = [$sortOrder];
        }

        foreach ($sortOrder as $_sort) {
            if (in_array($_sort, array_keys(self::$allowedSorting))) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;

                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->paginate($perPage);
    }

    public function scopeCategorySlug($query, $value)
    {
        return $query->whereHas('category', function($query) use ($value){
            $query->whereSlug($value);
        });
    }

    public function scopeIsPublished($query)
    {
        return $query->where('published_at', '>=', Carbon::today()->toDateString())->where('is_active', true);
    }

    public function scopeIsFeatured($query, $value = 1)
    {
        return $query->where('is_featured', $value);
    }

    public function beforeSave()
    {
        if ($this->newsletter_send) {
            $newsSender = new NewsSender($this);
            $newsSender->sendNewsletter();
        }
    }

    public function beforeCreate()
    {
        $this->views = 0;
        $this->user_id = BackendAuth::getUser()->id;
    }

    public function postView()
    {
        $this->increment('views');
    }
}
