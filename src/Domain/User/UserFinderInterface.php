<?php

declare(strict_types=1);

namespace App\Domain\User;

use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Uid\Uuid;

interface UserFinderInterface extends UserProviderInterface, PasswordUpgraderInterface
{
    public function findAll(): array;
    public function findById(Uuid $id): UserEntity;
}
