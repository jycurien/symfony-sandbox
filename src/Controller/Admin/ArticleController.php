<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\StaticHtmlHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/articles', name: 'admin_article_')]
class ArticleController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(ArticleRepository $repository)
    {
        return $this->render('admin/article/index.html.twig', ['articles' => $repository->findLatest()]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, StaticHtmlHandler $htmlHandler): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setStaticUrl($htmlHandler->generateHtmlFile($article));

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/{slug}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Article $article, StaticHtmlHandler $htmlHandler)
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $htmlHandler->deleteHtmlFile($article);
            $article->setStaticUrl($htmlHandler->generateHtmlFile($article));

            $entityManager->flush();
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article/edit.html.twig', [
            'form' => $form,
            'article' => $article,
        ]);
    }

    #[Route(path: '/{slug}', name: 'delete', methods: ['DELETE'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, Article $article, StaticHtmlHandler $htmlHandler)
    {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-article', $submittedToken)) {
            $htmlHandler->deleteHtmlFile($article);
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_index');
    }
}