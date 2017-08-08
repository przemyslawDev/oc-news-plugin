<?php

namespace PrzemyslawDev\News\Components;

use Cms\Classes\ComponentBase;
use Przemyslawdev\News\Models\Category;

class Categories extends ComponentBase
{
    public $categories;

    public function componentDetails()
    {
        return [
            'name' => 'Categories',
            'description' => ''
        ];
    }

    public function onRun()
    {
        $this->page['categories'] = $this->categories = $this->loadCategories();
    }

    protected function loadCategories()
    {
        $categories = Category::all();

        return $categories;
    }
}
