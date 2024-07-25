<?php
namespace App\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
#[Route("/auth/discord", name: "auth_discord_")]
final class DiscordOAuthController
{
    #[Route("/login", name: "login")]
    public function login(Request $request, ClientRegistry $clientRegistry, #[CurrentUser] ?User $user): Response
    {
    }

    #[Route("/start", name: "start")]
    public function start(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry->getClient("discord")->redirect(["identify", "guilds", "email"]);
    }
}