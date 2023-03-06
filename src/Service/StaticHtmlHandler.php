<?php

namespace App\Service;

use App\Entity\Article;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class StaticHtmlHandler
{
    public function __construct(
        private Filesystem $filesystem,
        private Environment $environment
    )
    {
    }

    /**
     * @param Article $article
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generateHtmlFile(Article $article): string
    {
        if (!$this->filesystem->exists('articles')) {
            $this->filesystem->mkdir('articles');
        }

        $staticFileUrl = 'articles/' . $article->getSlug() . '.html';
        $html = $this->environment->render('article/show.html.twig', ['article' => $article]);

        $this->filesystem->appendToFile($staticFileUrl, $html);

        return $staticFileUrl;
    }

    public function deleteHtmlFile(Article $article): void
    {
        if (null !== $article->getStaticUrl() && $this->filesystem->exists($article->getStaticUrl())) {
            $this->filesystem->remove($article->getStaticUrl());
        }
    }
}