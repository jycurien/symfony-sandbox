<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/articles', name: 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $repository): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($article);
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article/new.html.twig', [
            'form' => $form,
        ]);
    }
}