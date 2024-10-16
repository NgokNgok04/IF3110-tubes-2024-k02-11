<?php

namespace App\Core;

class Router {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        $this->resolveController($url);
        $this->resolveMethod($url);
        $this->params = $url ? array_values($url) : [];
    }

    public function parseURL()
    {
        $request = $_SERVER['REQUEST_URI'];
        $request = rtrim($request, '/');
        $request = filter_var($request, FILTER_SANITIZE_URL);
        return explode('/', $request);
    }

    protected function resolveController(&$url)
    {
        if (isset($url[1])) {
            $controllerName = ucfirst($url[1]) . 'Controller';
            $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[1]);
            }
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass;
    }

    protected function resolveMethod(&$url)
    {
        $methodPart = $url[2] ?? null;
        if (isset($methodPart)) {
            if (method_exists($this->controller, $methodPart)) {
                $this->method = $methodPart;
                unset($url[2]);
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }
}