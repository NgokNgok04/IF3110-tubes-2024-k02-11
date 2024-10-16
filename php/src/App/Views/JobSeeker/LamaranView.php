<?php

namespace App\Views\JobSeeker;
use App\Interfaces\ViewInterface;

class LamaranView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/JobSeeker/Lamaran.php';
    }
}