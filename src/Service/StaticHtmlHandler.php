<?php

namespace App\Service;

use App\Entity\Article;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class StaticHtmlHandler
{
    private string $publicDir;

    public function __construct(
        private readonly Filesystem   $filesystem,
        private readonly Environment $environment,
        readonly ParameterBagInterface $parameterBag
    )
    {
        $this->publicDir = $parameterBag->get('kernel.project_dir') . '/public/';
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
        if (!$this->filesystem->exists($this->publicDir . 'articles')) {
            $this->filesystem->mkdir($this->publicDir . 'articles');
        }

        $staticFileUrl = 'articles/' . $article->getSlug() . '.html';
        $html = $this->environment->render('article/show.html.twig', ['article' => $article]);

        $this->filesystem->appendToFile($this->publicDir . $staticFileUrl, $html);

        return $staticFileUrl;
    }

    public function deleteHtmlFile(Article $article): void
    {
        if (null !== $article->getStaticUrl() && $this->filesystem->exists($this->publicDir . $article->getStaticUrl())) {
            $this->filesystem->remove($this->publicDir . $article->getStaticUrl());
        }
    }
}