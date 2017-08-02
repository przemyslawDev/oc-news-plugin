<?php

namespace Przemyslawdev\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('przemyslawdev_content_news_news', function ($table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id');
            $table->string('title');
            $table->string('slug')->index();
            $table->text('summary');
            $table->text('content');
            $table->string('image', 200)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->biginteger('views');
            $table->boolean('newsletter_send');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('przemyslawdev_content_news_categories');
        });
    }

    public function down()
    {
        Schema::drop('przemyslawdev_content_news_news');
    }
}
