<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Service\StaticHtmlHandler;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::preRemove, method: 'preRemove', entity: Article::class)]
class ArticlePreRemoveListener
{
    public function __construct(private readonly StaticHtmlHandler $htmlHandler)
    {
    }

    public function preRemove(Article $article, LifecycleEventArgs $event): void
    {
        $this->htmlHandler->deleteHtmlFile($article);
    }
}