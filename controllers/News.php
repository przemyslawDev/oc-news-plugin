<?php

namespace Przemyslawdev\News\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Przemyslawdev\News\Models\News as NewsPost;

class News extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController'
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['przemyslawdev.news.access_news'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Przemyslawdev.News', 'news', 'news');
    }

    public function onActivate()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            foreach ($checkedIds as $id) {
                if ($news = NewsPost::find($id)) {
                    $news->is_active = true;
                    $news->save();
                }
            }
        }

        return $this->listRefresh();
    }

    public function onDeactivate()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {
            foreach ($checkedIds as $id) {
                if ($news = NewsPost::find($id)) {
                    $news->is_active = false;
                    $news->save();
                }
            }
        }

        return $this->listRefresh();
    }
}
