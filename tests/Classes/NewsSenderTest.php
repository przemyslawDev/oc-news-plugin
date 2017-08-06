<?php

namespace Przemyslawdev\Tests\Classes;

use Backend\Facades\BackendAuth;
use Przemyslawdev\News\Models\News;
use Przemyslawdev\News\Classes\NewsSender;
use PluginTestCase;
use Carbon\Carbon;
use Przemyslawdev\News\Models\Subscriber;
use Przemyslawdev\News\Models\Category;

class NewsSenderTest extends PluginTestCase
{
    protected $news;

    public function setUp()
    {
        parent::setUp();

        Subscriber::create(['email' => 'test@email.com', 'is_active' => true]);

        BackendAuth::authenticate([
            'login' => 'admin',
            'password' => 'admin'
        ]);

        $category = new Category();
        $category->name = 'test';
        $category->slug = 'test';
        $category->save();

        $this->news = News::create([
            'title' => 'test',
            'slug' => 'test',
            'category_id' => '1',
            'summary' => 'test',
            'content' => 'test',
            'image' => 'test',
            'published_at' => Carbon::now(),
            'newsletter_send_status' => '1'
        ]);
    }

    public function testSend()
    {
        $newsSender = new NewsSender($this->news);
        $newsSender->sendNewsletter();
    }
}