<?php

namespace Przemyslawdev\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('przemyslawdev_content_news_categories', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('przemyslawdev_content_news_categories');
    }
}
