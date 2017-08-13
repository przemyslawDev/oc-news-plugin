<?php

namespace PrzemyslawDev\News\Components;

use Cms\Classes\ComponentBase;
use Przemyslawdev\News\Models\Category;
use Przemyslawdev\News\Models\News as NewsModel;

class NewsPosts extends ComponentBase
{
    public $newsPosts;

    public $selectedCategory;

    public $noPostMessage;

    public function componentDetails()
    {
        return [
            'name' => 'News Posts',
            'description' => ''
        ];
    }

    public function defineProperties()
    {
        return [
            'perPage' => [
                'title' => 'perPage',
                'type' => 'string',
                'description' => '',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => '',
                'default' => '10'
            ],
            'noPostMessage' => [
                'title' => 'noPostMessage',
                'type' => 'string',
                'description' => '',
                'default' => 'No news found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title' => 'sort',
                'description' => '',
                'type' => 'dropdown',
                'default' => 'published desc'
            ],
            'category' => [
                'title' => 'category',
                'type' => 'dropdown',
                'description' => '',
                'default' => 'all',
            ],
            'featured' => [
                'title' => 'featured',
                'type' => 'dropdown',
                'description' => '',
                'default' => 0,
                'options' => [
                    0 => 'All News',
                    1 => 'Featured News',
                    2 => 'No Featured News'
                ]
            ]
        ];
    }

    public function onRun()
    {
        if(($category_slug = $this->property('category')) !== 'all') {
            $this->selectedCategory = Category::slug($category_slug)->first();
        }
        $this->page['newsPosts'] = $this->newsPosts = $this->loadNewsPosts();
        $this->page['noPostMessage'] = $this->noPostMessage = $this->property('noPostMessage');
    }

    public function getCategoryOptions()
    {
        $categories_options = array(
            'all' => 'All'
        );
        $categories = Category::all();

        foreach ($categories as $category) {
            $categories_options[$category->slug] = $category->name;
        }

        return $categories_options;
    }

    public function getSortOrderOptions()
    {
        return [
            'title asc' => 'title asc',
            'title desc' => 'title desc',
            'created_at asc' => 'created asc',
            'created_at desc' => 'created desc',
            'updated_at asc' => 'updated asc',
            'updated_at desc' => 'updated desc',
            'published_at asc' => 'published asc',
            'published_at desc' => 'published desc',
            'views asc' => 'views asc',
            'views desc' => 'views desc'
        ];
    }

    protected function loadNewsPosts()
    {
        $newsPosts = NewsModel::listFrontend([
            'perPage' => $this->property('perPage'),
            'sortOrder' => $this->property('sortOrder'),
            'category' => $this->property('category'),
            'featured' => $this->property('featured')
        ]);

        return $newsPosts;
    }
}
