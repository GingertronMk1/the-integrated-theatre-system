<?php

declare(strict_types=1);

namespace App\Application\Person;

use App\Application\Fixtures\DependentFixtureInterface;
use App\Application\User\UserFixture;
use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\ValueObject\PersonId;

final readonly class PersonFixture implements DependentFixtureInterface
{
    public function __construct(
        private PersonRepositoryInterface $personRepository
    ) {
    }

    public function getDependencies(): array
    {
        return [UserFixture::class];
    }

    public function load(): void
    {
        foreach ($this->getFixtures() as $fixture) {
            $this->personRepository->savePerson($fixture);
        }
    }

    /**
     * @return array<PersonEntity>
     */
    public function getFixtures(): array
    {
        return [
            self::testPerson1(),
        ];
    }

    public static function testPerson1(): PersonEntity
    {
        return new PersonEntity(
            PersonId::fromString('018cbbfc-c4dc-7326-bdc4-29a294cce2c4'),
            'Test Person 1',
            '',
            2015,
            2019,
            UserFixture::testUser1()->id
        );
    }
}
