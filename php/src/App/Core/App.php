<?php

namespace App\Core;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        // print_r($url);
        if (isset($url[1])) {
            $controllerName = ucfirst($url[1]) . 'Controller';
            $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';
            // print_r('\n' . $controllerFile);
            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[1]);
            }
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass;

        $methodPart = $url[2] ?? null;
        // var_dump($methodPart);
        if (isset($methodPart)) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $methodPart;
                unset($url[2]);
            }
        }
        
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // public function parseURL()
    // {
    //     if (isset($_GET['url'])) {
    //         // echo $_GET['url'];
    //         $url = rtrim($_GET['url'], '/');
    //         $url = filter_var($url, FILTER_SANITIZE_URL);
    //         return explode('/', $url);
    //     }
    //     return [];
    // }

    public function parseURL(){
        $request = $_SERVER['REQUEST_URI'];
        $request = rtrim($request, '/');
        $request = filter_var($request, FILTER_SANITIZE_URL);
        $request = explode('/', $request);
        return $request;
    }
}
