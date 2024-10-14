<?php

namespace App\Core; 
use App\Views\TestView;

class Controller {
    public function view($view, $data = [])
    {
        $test = new TestView(); 
        $test->render();
    }


}