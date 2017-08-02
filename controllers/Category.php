<?php

namespace Przemyslawdev\News\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Category extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['przemyslawdev.news.access_categories'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Przemyslawdev.News', 'news', 'news');
    }
}
