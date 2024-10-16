<?php

namespace App\Core;

class App {
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
        $controller = $this->router->getController();
        $method = $this->router->getMethod();
        $params = $this->router->getParams();

        call_user_func_array([$controller, $method], $params);
    }
}