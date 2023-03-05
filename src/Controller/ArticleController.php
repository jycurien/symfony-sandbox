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
        return $this->render('article/index.html.twig', ['articles' => $repository->findLatest()]);
    }

    #[Route(path: '/articles/{slug}', name: 'article_show')]
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', ['article' => $article]);
    }
}