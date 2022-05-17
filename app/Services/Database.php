<?php

namespace App\Services;

class Database implements IDatabase
{

    static $db;

    public static function all()
    {
        try {
            $articles = self::$db->get('articles');
            $articles = (array)json_decode($articles);
            header("Content-Type: application/json");
            $articles = json_encode(['status' => true, 'code' => 200 ,'data' => $articles]);
            echo $articles;
        }catch (\Exception $e){
            $data = ['message' => $e];
            echo json_encode(['status' => false, 'code' => 500, 'data' => $data]);
        }
    }

    public static function delete($key)
    {
        try {
            $article = self::$db->get('articles');
            $article = (array) json_decode($article);
            unset($article[$key]);
            if (!empty($article)){
                $article = json_encode($article);
                self::$db->set('articles', $article);
            }else{
                self::$db->del('articles');
            }
            header("Content-Type: application/json");
            $articles = json_encode(['status' => true, 'code' => 200 ,'data' => []]);
            echo $articles;
        }catch (\Exception $e){
            $data = ['message' => $e];
            echo json_encode(['status' => false, 'code' => 500, 'data' => $data]);
        }
    }

    public static function start($dbClass)
    {
        self::db($dbClass);
    }

    public static function db($dbClass)
    {
        try {
            self::$db = $dbClass;
        } catch (\Exception $e) {
            echo "Ошибка соединения с базой данных" . $e->getMessage();
        }
    }
}