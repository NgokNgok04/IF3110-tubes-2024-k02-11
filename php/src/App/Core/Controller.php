<?php

namespace App\Core;

class Controller
{
    public function view($folder, $view, $data = [])
    {
        $controllerClass = 'App\\Views\\' . $folder . "\\" . $view;
        return new $controllerClass($data);
    }

    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        $objectModel = new $modelClass;
        return $objectModel;
    }
}
