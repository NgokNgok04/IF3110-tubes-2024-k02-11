<?php

namespace App\Core;

class Controller
{
    public function view($folder, $view, $data = [])
    {
        $controllerClass = 'App\\Views\\' . $folder . "\\" . $view;
        echo $controllerClass;
        return new $controllerClass;
    }

    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        return new $modelClass;
    }
}