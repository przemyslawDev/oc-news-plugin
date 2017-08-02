<?php

namespace Przemyslawdev\News\Classes;

use Mail;

class SubscriptionSender
{
    protected $subscriber;

    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function send()
    {
        Mail::send('przemyslawdev.news::mail.subscription', function ($message) {
            $message->to($this->subscriber->email, '');
            $message->subject('Thanks for subscribe.');
        });
    }
}
