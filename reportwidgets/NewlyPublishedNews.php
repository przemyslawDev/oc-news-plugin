<?php

namespace Przemyslawdev\News\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Przemyslawdev\News\Models\News;

class NewlyPublishedNews extends ReportWidgetBase
{
    protected $defaultAlias = 'Newly Published News';

    public function render()
    {
        $this->loadData();

        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Newly Published News',
                'default' => 'Newly Published News',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ]
        ];
    }

    protected function loadData()
    {
        $this->vars['news'] = News::isPublished()->orderBy('published_at', 'desc')->take(5)->get();
    }
}
