<?php

namespace App\EventListener;

use App\Entity\Articles;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class SlugListener implements EventSubscriber
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof Articles) {
            $this->setSlug($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof Articles) {
            $this->setSlug($entity);
        }
    }

    private function setSlug(Articles $entity): void
    {
        if (empty($entity->getSlug())) {
            $slug = $this->slugger->slug($entity->getTitle())->lower();
            $entity->setSlug($slug);
        }
    }
}