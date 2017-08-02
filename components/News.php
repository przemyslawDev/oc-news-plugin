<?php

namespace PrzemyslawDev\News\Components;

use Backend\Facades\BackendAuth;
use Cms\Classes\ComponentBase;
use Event;
use Przemyslawdev\News\Models\News as NewsPost;
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
                'description' => '',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->page['news'] = $this->news = $this->loadNews();
    }

    protected function loadNews()
    {
        $slug = $this->property('slug');

        $news = NewsPost::where('slug', $slug);

        if ($news->count() == 0) {
            return Redirect::to('404');
        }

        $news = $news->first();

        if (!BackendAuth::check()) {
            Event::fire('post.view', $news);
        }

        return $news;
    }
}
