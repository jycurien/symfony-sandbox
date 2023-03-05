<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home_index')]
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findLatest(4);
        dd($articles);
    }
}