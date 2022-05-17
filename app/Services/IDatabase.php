<?php

namespace App\Services;

interface IDatabase
{
    public static function all();

    public static function delete($key);

    public static function start($dbClass);

    public static function db($dbClass);
}