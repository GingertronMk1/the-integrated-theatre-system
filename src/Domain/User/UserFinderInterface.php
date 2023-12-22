<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\ValueObject\UserId;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserFinderInterface extends UserProviderInterface, PasswordUpgraderInterface
{
    public function findAll(): array;

    public function findById(UserId $id): UserEntity;
}
