<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\ValueObject\UserId;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserModel implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param array<int, mixed> $roles
     */
    public function __construct(
        public UserId $id,
        public string $email,
        public array $roles,
        public string $password
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
