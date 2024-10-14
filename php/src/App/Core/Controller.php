<?php

namespace App\Core; 

class Controller {
    public function view($folder, $view, $data = [])
    {
        $controllerClass = 'App\\Views\\' . $folder . "\\". $view;
        $objectView = new $controllerClass;
        return $objectView;
    }

    public function model($model){
        $modelClass = 'App\\Models\\' . $model;
        // echo $modelClass;
        $objectModel = new $modelClass;
        return $objectModel;
    }
}