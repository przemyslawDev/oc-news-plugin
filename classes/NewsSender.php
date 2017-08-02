<?php

namespace Przemyslawdev\News\Classes;

use File;
use Mail;
use Przemyslawdev\News\Models\Settings;
use Przemyslawdev\News\Models\Subscriber;

class NewsSender
{
    protected $news;

    protected $templateBasePath = 'przemyslawdev.news::mail.newsletter_email_';

    public function __construct($news)
    {
        $this->news = $news;
    }

    public function sendNewsletter()
    {
        $activeSubscribers = Subscriber::isActive();
        if ($activeSubscribers->count() == 1) {
            $this->send($activeSubscribers->first());
        } else {
            if ($activeSubscribers->count() > 1) {
                $subscribers = $activeSubscribers->get();
                foreach ($subscribers as $subscriber) {
                    $this->send($subscriber);
                }
            }
        }
    }

    protected function template()
    {
        $templates = array();

        $templateCounter = 1;
        while ($templateCounter < Settings::get('newsletter_template_count', 1) + 1) {
            if (File::exists(base_path() . '/plugins/przemyslawdev/news/views/mail/newsletter_email_' . $templateCounter . '.htm')) {
                $templates[] = $this->templateBasePath . $templateCounter;
            }
            $templateCounter++;
        }
        return $this->getRandomTemplate($templates);
    }

    protected function getRandomTemplate($templates)
    {
        if (count($templates) > 0) {
            $random = random_int(0, count($templates) - 1);
        } else {
            $random = 0;
        }
        return $templates[$random];
    }

    protected function send($subscriber)
    {
        $vars = [
            'post_title' => $this->news->title,
            'post_slug' => $this->news->slug,
            'post_category_name' => $this->news->category->name,
            'post_summary' => $this->news->summary,
            'post_content' => $this->news->content,
            'post_is_featured' => $this->news->is_featured,
            'post_image' => $this->news->image
        ];

        Mail::send($this->template(), $vars, function ($message) use ($subscriber) {
            $message->to($subscriber->email, '');
            $message->subject($this->news->title);
        });
    }
}
