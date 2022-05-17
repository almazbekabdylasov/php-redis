<?php

namespace App\Services;

class Page
{
    /**
     * @param $part_name
     * @return void
     */
    public static function part($part_name)
    {
        require_once "views/components/" . $part_name . ".php";
    }
}