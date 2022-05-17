<?php

use App\Services\Database;
use Predis\Client;
require_once __DIR__ . '/vendor/autoload.php';
if ($argv[2] == 'redis'){
    Database::start(new Client());
}elseif($argv[2] == 'memcache'){
    Database::start(new Memcache());
}


if ($argv[1] == './command'){
    $database = Database::$db;
    switch ($argv[3]){
        case 'add':
            if ($database->exists('articles')){
                $array = json_decode($database->get('articles'));
                $array = (array) $array;
                if(!isset($array[$argv[4]])){
                    $array[$argv[4]] = $argv[5];
                    $result = json_encode($array);
                    $database->set('articles', $result);
                }else{
                    print 'Такое ключ уже есть';
                }
            }else {
                $test = json_encode([$argv[4] => $argv[5]]);
                $database->set('articles', $test);
                $database->expire('articles', 600);
            }
            break;
        case 'delete':
            $test = $database->get('articles');
            $test = json_decode($test);
            $test = (array) $test;
            unset($test[$argv[4]]);
            if (!empty($test)){
                $test2 = json_encode($test);
                $database->set('articles', $test2);
            }else{
                $database->del('articles');
            }
    }
}


