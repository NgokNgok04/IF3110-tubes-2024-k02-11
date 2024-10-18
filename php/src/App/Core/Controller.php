<?php

namespace App\Core;

class Controller
{
    public function view($folder, $view, $data = [])
    {
        $controllerViews = __DIR__ . '/../Views/' . $folder . "/" . $view . ".php";
        extract($data);
        require_once $controllerViews;
    }

    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        $objectModel = new $modelClass;
        return $objectModel;
    }
}
