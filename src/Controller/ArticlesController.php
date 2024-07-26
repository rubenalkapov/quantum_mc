<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticlesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Vérifier si l'utilisateur est un admin
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            // Rediriger vers la page d'accueil si l'utilisateur n'est pas un admin
            return $this->redirectToRoute('home');
        }

        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception
                }

                $article->setImage($newFilename);
            }

            // Générer et définir le slug
            $slug = $slugger->slug($article->getTitle())->lower();
            $article->setSlug($slug);

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/articles', name: 'articles')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Articles::class)->findAll();
        return $this->render('articles/articlesList.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/{slug}', name: 'article_show')]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Articles $articles): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $articles,
        ]);
    }

    #[Route('/access-denied', name: 'access_denied')]
    public function accessDenied(): RedirectResponse
    {
        return $this->redirectToRoute('home');
    }
}
