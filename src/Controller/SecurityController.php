<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class SecurityController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {

    }
}
