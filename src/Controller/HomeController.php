<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Articles;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/jouer', name: 'play')]
    public function play(): Response
    {
        return $this->render('play/play.html.twig');
    }

    #[Route('/articles', name: 'articles')]
    public function articles(EntityManagerInterface $entityManager, Request $request): Response
    {
        $articles = $entityManager->getRepository(Articles::class)->findAll();

        return $this->render('articles/articlesList.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/articles/{slug}')]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Articles $articles): Response {
        return $this->render('play/play.html.twig', [
            'articles' => $articles
        ]);
    }
}
