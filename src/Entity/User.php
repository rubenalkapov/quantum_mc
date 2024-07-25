<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Psr\Log\LoggerInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private ?string $discordId;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $avatarHash;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $username;

    #[ORM\Column(type:"json")]
    private $roles = [];

    // Les méthodes getters et setters
    private readonly LoggerInterface $logger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(string $discordId): self
    {
        $this->discordId = $discordId;

        return $this;
    }

    public function setAvatarHash(?string $avatarHash): self
    {
        $this->avatarHash = $avatarHash;

        return $this;
    }

    public function getAvatarHash(): ?string
    {
        return $this->avatarHash;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    // Autres méthodes de l'interface UserInterface
    public function getRoles(): array
    {
        $roles = $this->roles;

        // assure que chaque utilisateur a au moins ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return $this->discordId;
    }
}
