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

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Article::class)]
class ArticlePrePersistListener
{
    public function __construct(private readonly StaticHtmlHandler $htmlHandler)
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function prePersist(Article $article, LifecycleEventArgs $event): void
    {
        $article->setStaticUrl($this->htmlHandler->generateHtmlFile($article));
    }
}