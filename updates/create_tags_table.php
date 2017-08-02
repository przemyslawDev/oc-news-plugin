<?php

namespace Przemyslawdev\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('przemyslawdev_content_news_tags', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('przemyslawdev_content_news_news_tags', function ($table) {
            $table->integer('news_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->primary(['news_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::drop('przemyslawdev_content_news_tags');
        Schema::drop('przemyslawdev_content_news_news_tags');
    }
}
