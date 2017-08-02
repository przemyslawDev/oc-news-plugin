<?php

namespace Przemyslawdev\News\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use PrzemyslawDev\News\Models\Category;
use PrzemyslawDev\News\Models\News;
use Przemyslawdev\News\Models\NewsStatistics;

class Statistics extends Controller
{
    protected $news;

    public $implement = [

    ];

    public $requiredPermissions = ['przemyslawdev.news.access_statistics'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Przemyslawdev.News', 'news', 'news');
    }

    public function index()
    {
        $this->pageTitle = 'Statistics';
    }

    public function onGetCategories()
    {
        return $this->vars['categories'] = Category::orderBy('id', 'desc')->get();
    }

    public function onGetCategoriesNewsViews()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $categories_total_views = array();
        foreach ($categories as $category) {
            $views_total = News::where('category_id', $category->id)->sum('views');
            array_push($categories_total_views, $views_total);
        }
        return $this->vars['categories_total_views'] = array('views_totals' => $categories_total_views);
    }
}
