<?php

namespace Przemyslawdev\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('przemyslawdev_content_news_subscribers', function ($table) {
            $table->increments('id');
            $table->string('email');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('przemyslawdev_content_news_subscribers');
    }
}
