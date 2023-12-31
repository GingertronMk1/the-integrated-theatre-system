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
            self::testPerson2(),
            self::testSessionPerson1(),
            self::testSessionPerson2(),
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

    public static function testPerson2(): PersonEntity
    {
        return new PersonEntity(
            PersonId::fromString('018cbfc9-8616-77a7-9d94-2e77bbee9288'),
            'Test Person 2',
            '',
            2015,
            2019,
            UserFixture::testUser2()->id
        );
    }

    public static function testSessionPerson1(): PersonEntity
    {
        return new PersonEntity(
            PersonId::fromString('018cc024-c162-73b4-a93a-bef79c2acbf6'),
            'Test Session Person 1',
            '',
            2015,
            2019,
            null
        );
    }

    public static function testSessionPerson2(): PersonEntity
    {
        return new PersonEntity(
            PersonId::fromString('018cc024-ff45-79b5-b57e-aa874a94b83b'),
            'Test Session Person 2',
            '',
            2015,
            2019,
            null
        );
    }
}
