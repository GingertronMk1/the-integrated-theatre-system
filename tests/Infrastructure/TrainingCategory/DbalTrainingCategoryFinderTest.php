<?php

declare(strict_types=1);

namespace Tests\Infrastructure\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Infrastructure\TrainingCategory\DbalTrainingCategoryFinder;
use App\Infrastructure\TrainingCategory\DbalTrainingCategoryRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group infrastructure
 */
final class DbalTrainingCategoryFinderTest extends TestCase
{
    private Connection|MockObject $connection;
    private DbalTrainingCategoryFinder $finder;
    private QueryBuilder|MockObject $queryBuilder;
    private TrainingCategoryId $id;

    public function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->finder = new DbalTrainingCategoryFinder($this->connection);
        $this->queryBuilder = $this->createMock(QueryBuilder::class);
        $this->id = TrainingCategoryId::fromString('018cadbe-982b-7115-84af-052c544d9399');
    }

    /**
     * @test
     */
    public function testFind(): void
    {
        $name = 'Test TC';
        $now = new DateTimeImmutable('1997-04-15T17:00:00');

        $this->connection->expects($this->once())->method('createQueryBuilder')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('select')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('from')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('fetchAssociative')->willReturn([
            'id' => (string) $this->id,
            'name' => $name,
            'created_at' => $now->format('c'),
            'updated_at' => $now->format('c')
        ]);

        $model = $this->finder->find($this->id);
        $this->assertEquals($this->id, $model->id);
        $this->assertEquals($name, $model->name);
        $this->assertEquals($now, $model->createdAt);
        $this->assertEquals($now, $model->updatedAt);

    }

    /**
     * @test
     */
    public function testFindThrowsException(): void
    {
        $this->connection->expects($this->once())->method('createQueryBuilder')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('select')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('from')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('fetchAssociative')->willReturn(false);

        $this->expectException(Exception::class);
        $model = $this->finder->find($this->id);
    }

    /**
     * @test
     */
    public function testFindAll(): void
    {
        $this->connection->expects($this->once())->method('createQueryBuilder')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('select')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('from')->willReturn($this->queryBuilder);
        $this->queryBuilder->expects($this->once())->method('fetchAllAssociative')->willReturn([]);

        $models = $this->finder->findAll();
        $this->assertEmpty($models);

    }
}
