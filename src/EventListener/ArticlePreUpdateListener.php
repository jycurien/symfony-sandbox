<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Service\StaticHtmlHandler;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Article::class)]
class ArticlePreUpdateListener
{
    public function __construct(private readonly StaticHtmlHandler $htmlHandler)
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function preUpdate(Article $article, LifecycleEventArgs $event): void
    {
        $this->htmlHandler->deleteHtmlFile($article);
        $article->setStaticUrl($this->htmlHandler->generateHtmlFile($article));
    }
}