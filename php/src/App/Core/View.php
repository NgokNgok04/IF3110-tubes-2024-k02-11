<?php

namespace App\Core;

use App\Interfaces\ViewInterface;

class View implements ViewInterface {
    protected $data = [];

    public function setData(array $data) {
        $this->data = $data;
    }

    public function render() {
        extract($this->data);
    }
}