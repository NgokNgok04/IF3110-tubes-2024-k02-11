<?php

namespace App\Core;

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        print_r($url);
        if (isset($url[0])) {
            $controllerFile = __DIR__ . '/../controllers/' . ucfirst($url[0]) . '.php';
            if (file_exists($controllerFile)) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass;

        $methodPart = $url[1] ?? null;
        // var_dump($methodPart);
        if (isset($methodPart)) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $methodPart;
                unset($url[1]);
            }
        }
        
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // echo $_GET['url'];
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
