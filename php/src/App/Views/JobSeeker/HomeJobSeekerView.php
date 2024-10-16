<?php

namespace App\Views\JobSeeker;
use App\Interfaces\ViewInterface;

class HomeJobSeekerView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/JobSeeker/HomeJobSeeker.php';
    }
}