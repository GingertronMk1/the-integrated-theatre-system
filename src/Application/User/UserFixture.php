<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Application\Fixtures\FixtureInterface;
use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserFixture implements FixtureInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(): void
    {
        foreach ($this->getFixtures() as $fixture) {
            $hashedPassword = $this->userPasswordHasher->hashPassword($fixture, $fixture->password);
            $this
                ->userRepository
                ->createUser(
                    new UserEntity(
                        $fixture->id,
                        $fixture->email,
                        $fixture->roles,
                        $hashedPassword
                    )
                );
        }
    }

    /** @return array<int, UserEntity> */
    public function getFixtures(): array
    {
        return [self::testUser1()];
    }

    public static function testUser1(): UserEntity
    {
        return new UserEntity(
            UserId::fromString('018cbbf7-9728-7f68-882c-ea116410442f'),
            'test1@tits.test',
            [],
            'test'
        );
    }
}
