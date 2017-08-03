<?php

namespace PrzemyslawDev\News\Components;

use Backend\Facades\BackendAuth;
use Cms\Classes\ComponentBase;
use Event;
use Przemyslawdev\News\Models\News as NewsPost;
use Przemyslawdev\News\Models\Category;
use Redirect;

class News extends ComponentBase
{
    public $news;

    public function componentDetails()
    {
        return [
            'name' => 'News',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'slug',
                'description' => 'News slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ],
            'category_slug' => [
                'title' => 'category_slu',
                'description' => 'Category slug',
                'default' => '{{ :category_slug }}',
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->news = $this->loadNews();
        if(!$this->news){
            return Redirect::to('404');
        }
        $this->page['news'] = $this->news;
    }

    protected function loadNews()
    {
        $slug = $this->property('slug');
        $category_slug = $this->property('category_slug');

        $category = Category::where('slug', $category_slug);
        if($category->count() == 0)
            return null;

        $category = $category->first();

        $news = NewsPost::where('slug', $slug)->category($category->id);

        if ($news->count() == 0)
            return null;

        $news = $news->first();

        if (!BackendAuth::check())
            Event::fire('post.view', $news);

        return $news;
    }
}
