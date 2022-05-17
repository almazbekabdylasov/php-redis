<?php

namespace App\Models;

use App\Services\App;
use App\Services\Database;

class Article
{

    public static function all()
    {
        return Database::all();
    }

    public static function delete($article)
    {
        return Database::delete($article);
    }
}