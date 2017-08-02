<?php

namespace Przemyslawdev\News\Classes;

class PostViewHandler
{
    public function handle($news)
    {
        $news->postView();
    }
}
