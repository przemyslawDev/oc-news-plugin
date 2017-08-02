<?php

namespace Przemyslawdev\News\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Subscriber extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController'
    ];

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['przemyslawdev.news.access_subscribers'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Przemyslawdev.News', 'news', 'news');
    }
}
