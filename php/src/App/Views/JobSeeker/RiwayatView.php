<?php

namespace App\Views\JobSeeker;
use App\Interfaces\ViewInterface;

class RiwayatView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/JobSeeker/Riwayat.php';
    }
}