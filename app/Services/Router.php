<?php
namespace App\Services;

class Router
{
    private static $list = [];

    /**
     * @param $uri
     * @param $page_name
     * @return void
     */
    public static function page($uri, $page_name)
    {
        self::$list[] = [
            "uri" => $uri,
            "page" => $page_name
        ];
    }

    public static function post($uri, $class, $method,$formdata = false)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "post" => true,
            "formdata" => $formdata,
        ];
    }


    public static function delete($uri, $class, $method,$formdata = false)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "delete" => true,
            "formdata" => $formdata,
        ];
    }

    public static function get($uri, $class, $method)
    {
        self::$list[] = [
            "uri" => $uri,
            "class" => $class,
            "method" => $method,
            "get" => true,
        ];
    }

    /**
     * @return void
     */
    public static function enable()
    {
        $query = $_SERVER['REQUEST_URI'];


        foreach (self::$list as $route){
            if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
                preg_match("/[^\/]+$/", $_SERVER['REQUEST_URI'], $matches);
                $last_word = $matches[0];
                $deleteRequest = $route['uri'] . '/'. $last_word;
            }else {
                $deleteRequest = '';
            }
                if ($route["uri"] === $query || $deleteRequest === $query){
                    if (isset($route["post"]) === true && $_SERVER['REQUEST_METHOD'] === "POST"){
                        $action = new $route["class"];
                        $method = $route["method"];
                        if ($route["formdata"]) {
                            $action->$method($_POST);
                        }else{
                            $action->$method();
                        }
                        die();
                    }elseif (isset($route['get'])=== true){
                        $action = new $route['class'];
                        $method = $route["method"];
                        $action->$method();
                        die();
                    }elseif (isset($route['delete']) === true && $_SERVER['REQUEST_METHOD'] == 'DELETE'){
                        $action = new $route['class'];
                        $method = $route['method'];
                        $action->$method($last_word);
                        die();
                    }
                    else {
                        require_once "views/pages/" . $route['page']. ".php";
                        die();
                }
            }
        }
        self::not_found_page();
    }

    /**
     * @return void
     */
    private static function not_found_page()
    {
        require_once "views/errors/404.php";
    }

    public static function redirect($uri)
    {
        header("Location:" . $uri);
        require_once "views/pages/" . $uri . ".php";
        die();
    }
}