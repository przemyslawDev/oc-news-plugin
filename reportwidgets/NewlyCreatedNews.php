<?php

namespace Przemyslawdev\News\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Przemyslawdev\News\Models\News;

class NewlyCreatedNews extends ReportWidgetBase
{
    protected $defaultAlias = 'Newly Created News';

    public function render()
    {
        $this->loadData();

        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Newly Created News',
                'default' => 'Newly Created News',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ]
        ];
    }

    protected function loadData()
    {
        $this->vars['news'] = News::orderBy('created_at', 'desc')->take(5)->get();
    }
}
