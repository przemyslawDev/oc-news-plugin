<?php


namespace Przemyslawdev\News;

use Backend\Facades\Backend;
use Db;
use Event;
use System\Classes\PluginBase;
use Przemyslawdev\News\Classes\NewsSender;
use Przemyslawdev\News\Models\News as NewsModel;

class Plugin extends PluginBase
{
    public function boot()
    {
        Event::listen('post.view', 'Przemyslawdev\News\Classes\PostViewHandler');
    }

    public function pluginDetails()
    {
        return [
            'name' => 'News Plugin',
            'description' => 'News Plugin',
            'author' => 'przemyslawDev',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerSettings()
    {
        return [
            'newsletter' => [
                'label' => 'Newsletter',
                'description' => 'Manage newsletter.',
                'category' => 'Przemyslawdev - News',
                'icon' => 'icon-envelope-o',
                'class' => 'Przemyslawdev\News\Models\Settings',
                'permissions' => ['przemyslawdev.news.access_settings'],
                'order' => 500
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'przemyslawdev.news.access_news' => [
                'label' => 'Show and Write news',
                'tab' => 'News',
                'order' => 510
            ],
            'przemyslawdev.news.access_edit_news' => [
                'label' => 'Edit news',
                'tab' => 'News',
                'order' => 510
            ],
            'przemyslawdev.news.access_delete_news' => [
                'label' => 'Delete news',
                'tab' => 'News',
                'order' => 510
            ],
            'przemyslawdev.news.access_active_news' => [
                'label' => 'Active news',
                'tab' => 'News',
                'order' => 510
            ],
            'przemyslawdev.news.access_categories' => [
                'label' => 'Show and Write categories',
                'tab' => 'News',
                'order' => 520
            ],
            'przemyslawdev.news.access_edit_categories' => [
                'label' => 'Edit categories',
                'tab' => 'News',
                'order' => 520
            ],
            'przemyslawdev.news.access_delete_categories' => [
                'label' => 'Delete categories',
                'tab' => 'News',
                'order' => 520
            ],
            'przemyslawdev.news.access_tags' => [
                'label' => 'Show tags',
                'tab' => 'News',
                'order' => 530
            ],
            'przemyslawdev.news.access_manage_tags' => [
                'label' => 'Manage tags',
                'tab' => 'News',
                'order' => 530
            ],
            'przemyslawdev.news.access_subscribers' => [
                'label' => 'Show Subscribers',
                'tab' => 'News',
                'order' => 540
            ],
            'przemyslawdev.news.access_statistics' => [
                'label' => 'Display statistics',
                'tab' => 'News',
                'order' => 550
            ],
            'przemyslawdev.news.access_settings' => [
                'label' => 'Plugin Settings',
                'tab' => 'News',
                'order' => 560
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'news' => [
                'label' => 'Content',
                'icon' => 'icon-newspaper-o',
                'url' => Backend::url('przemyslawdev/news/news'),
                'order' => 500,

                'sideMenu' => [
                    'news' => [
                        'label' => 'News',
                        'icon' => 'icon-file-text',
                        'url' => Backend::url('przemyslawdev/news/news')
                    ],
                    'subscribers' => [
                        'label' => 'Subscribers',
                        'icon' => 'icon-users',
                        'url' => Backend::url('przemyslawdev/news/subscriber')
                    ],
                    'statistics' => [
                        'label' => 'Statistics',
                        'icon' => 'icon-bar-chart',
                        'url' => Backend::url('przemyslawdev/news/statistics')
                    ]
                ]
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'Przemyslawdev\News\Components\News' => 'news',
            'Przemyslawdev\News\Components\NewsPosts' => 'news_posts',
            'Przemyslawdev\News\Components\Subscribe' => 'subscribe'
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'Przemyslawdev\News\ReportWidgets\NewlyCreatedNews' => [
                'label' => 'Newly created news',
                'context' => 'dashboard'
            ],
            'Przemyslawdev\News\ReportWidgets\NewlyPublishedNews' => [
                'label' => 'Newly published news',
                'context' => 'dashboard'
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'przemyslawdev.news::mail.subscription' => 'Welcome mail sent to new subscriber.',
            'przemyslawdev.news::mail.newsletter_email_1' => 'First newsletter email template.',
            'przemyslawdev.news::mail.newsletter_email_2' => 'Second newsletter email template.',
            'przemyslawdev.news::mail.newsletter_email_3' => 'Third newsletter email template.',
            'przemyslawdev.news::mail.newsletter_email_4' => 'Fourth newsletter email template.',
            'przemyslawdev.news::mail.newsletter_email_5' => 'Fifth newsletter email template.'
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            $newsToSend = NewsModel::where('newsletter_send_status', 2)->get();
            foreach($newsToSend as $news) {
                $newsSender = new NewsSender($news);
                $status = $newsSender->sendNewsletter();
                if($status) {
                    $news->newsletter_send_status = 4;
                } else {
                    $news->newsletter_send_status = 3;
                }
                $news->save();
            }
        })->everyMinute();
    }
}
