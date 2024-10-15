<?php

namespace App\Core;

class Controller {
    public function view($folder, $view)
    {
        $controllerClass = 'App\\Views\\' . $folder . "\\" . $view;
        echo $controllerClass;
        return new $controllerClass;
    }

    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        $objectModel = new $modelClass;
        return $objectModel;
    }
}
