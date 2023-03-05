<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route(path: '/', name: 'home_index')]
    public function index()
    {
        // TODO
        dd('THIS IS THE HOME PAGE');
    }
}