<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\ValueObject\UserId;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param UserId $id
     * @param string $email
     * @param array<int, mixed> $roles
     * @param string $password
     */
    public function __construct(
        private UserId $id,
        private string $email,
        private array $roles,
        private string $password
    ) {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
