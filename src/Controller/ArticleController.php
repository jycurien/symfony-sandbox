<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route(path: '/articles', name: 'article_index')]
    public function index(ArticleRepository $repository)
    {
        // TODO
        dd($repository->findAll());
    }

    #[Route(path: '/articles/{slug}', name: 'article_show')]
    public function show(Article $article)
    {
        // TODO
        dd($article);
    }
}