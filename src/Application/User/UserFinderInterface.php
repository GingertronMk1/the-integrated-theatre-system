<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\ValueObject\UserId;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @extends UserProviderInterface<UserModel>
 */
interface UserFinderInterface extends UserProviderInterface, PasswordUpgraderInterface
{
    /**
     * @return array<UserModel>
     */
    public function findAll(?int $offset = null, ?int $limit = null): array;

    public function find(UserId $id): UserModel;

    public function count(?UserId $id = null): int;
}
