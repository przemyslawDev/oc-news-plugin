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
        $vars = [];

        try {
            Mail::send('przemyslawdev.news::mail.subscription', $vars, function ($message) {
                $message->to($this->subscriber->email, '');
                $message->subject('Thanks for subscribe.');
            });
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
