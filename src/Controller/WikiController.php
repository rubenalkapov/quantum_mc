<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WikiController extends AbstractController
{
    #[Route('/wiki', name: 'app_wiki')]
    public function index(): Response
    {
        return $this->render('wiki/index.html.twig');
    }
}
