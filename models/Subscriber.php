<?php

namespace Przemyslawdev\News\Models;

use Model;
use Przemyslawdev\News\Classes\SubscriptionSender;

class Subscriber extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'przemyslawdev_content_news_subscribers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'is_active'
    ];

    public $rules = [
        'email' => 'required|email'
    ];

    public function scopeEmail($query, $value)
    {
        return $query->where('email', $value);
    }

    public function scopeIsActive($query, $value = 1)
    {
        return $query->where('is_active', $value);
    }

    public function afterSave()
    {
        $subscribtionSender = new SubscriptionSender($this);
        $subscribtionSender->send();
    }
}
