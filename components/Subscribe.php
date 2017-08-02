<?php

namespace PrzemyslawDev\News\Components;

use Cms\Classes\ComponentBase;
use PrzemyslawDev\News\Models\Subscriber;
use Redirect;

class Subscribe extends ComponentBase
{
    public $news;

    public function componentDetails()
    {
        return [
            'name' => 'Subscribe',
            'description' => ''
        ];
    }

    public function onRun()
    {
    }

    public function onSubscribe()
    {
        $data = post();

        $subscriber = Subscriber::email($data['email']);//Subscriber::email($data['email'])->first();

        if ($subscriber->count() > 0) {
            $subscriber->first();
            if (!$subscriber->isActive()) {
                $subscriber->is_active = true;
            }
        } else {
            $subscriber = new Subscriber();
            $subscriber->email = $data['email'];
            $subscriber->is_active = true;
            $subscriber->save();
        }
    }
}
