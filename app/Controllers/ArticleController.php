<?php

namespace App\Controllers;

use App\Models\Article;

class ArticleController
{
    public function all()
    {
        return Article::all();
    }

    public function delete($request)
    {
        return Article::delete($request);
    }
}