<?php

namespace App\router;

use App\model\database\Database;

class Routers
{
    protected array $getRoutes = [];
    protected array $postRoutes = [];
    public ?Database $database =null;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function get($url, $obj)
    {
        $this->getRoutes[$url] = $obj;
        return $this->getRoutes;
    }
    public function post($url, $obj)
    {
        $this->postRoutes[$url] = $obj;
    }
    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $trimUri = stripos($uri, '?');
        if ($trimUri !== false) {
            $uri = substr($uri, 0, $trimUri);
        }
        if ($method === 'GET') {
            $fn = $this->getRoutes[$uri];
        } 
        else {
            $fn = $this->postRoutes[$uri];
        }

        if (!empty($fn)) {
            [$controlerName, $methodName] = $fn;
            $controler = new $controlerName($this);
            call_user_func([$controler, $methodName]);
        }
    }
    public function renderView($view,$params =[]) {
        foreach($params as $key=>$value){
            $$key = $value;
        }

        ob_start();
        include_once "../view/$view.php";
        $content = ob_get_clean();
        include_once '../view/_layout.php';
    }
}
