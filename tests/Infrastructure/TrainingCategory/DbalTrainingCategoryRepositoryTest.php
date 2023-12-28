<?php

declare(strict_types=1);

namespace Tests\Infrastructure\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Infrastructure\TrainingCategory\DbalTrainingCategoryRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group infrastructure
 */
final class DbalTrainingCategoryRepositoryTest extends TestCase
{
    private Connection|MockObject $connection;
    private DbalTrainingCategoryRepository $repository;
    private TrainingCategoryEntity $entity;

    public function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->repository = new DbalTrainingCategoryRepository($this->connection);
        $this->entity = new TrainingCategoryEntity(
            $this->repository->getNextId(),
            'test'
        );
    }

    /**
     * @test
     */
    public function testGetNextId(): void
    {
        $id = $this->repository->getNextId();
        $this->assertTrue(TrainingCategoryId::isValid((string) $id));
    }

    /**
     * @test
     */
    public function createFunctionsCalledAsExpected(): void
    {
        $mockQueryBuilder = $this->createMock(QueryBuilder::class);
        $this->connection->expects($this->once())->method('createQueryBuilder')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('insert')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('values')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('setParameters')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('executeQuery');
        $this->repository->createTrainingCategory($this->entity);
    }

    /**
     * @test
     */
    public function updateFunctionsCalledAsExpected(): void
    {
        $mockQueryBuilder = $this->createMock(QueryBuilder::class);
        // Happens twice
        $this->connection->expects($this->exactly(2))->method('createQueryBuilder')->willReturn($mockQueryBuilder);
        // Select query
        $mockQueryBuilder->expects($this->once())->method('select')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('from')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->exactly(2))->method('where')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('setParameter')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('fetchOne')->willReturn(1);

        // Update query
        $mockQueryBuilder->expects($this->once())->method('update')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->exactly(2))->method('set')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('setParameters')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('executeQuery');
        $this->repository->updateTrainingCategory($this->entity);
    }

    /**
     * @test
     */
    public function noneFoundThrowsException(): void
    {
        $mockQueryBuilder = $this->createMock(QueryBuilder::class);
        // Happens twice
        $this->connection->expects($this->once())->method('createQueryBuilder')->willReturn($mockQueryBuilder);
        // Select query
        $mockQueryBuilder->expects($this->once())->method('select')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('from')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('where')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('setParameter')->willReturn($mockQueryBuilder);
        $mockQueryBuilder->expects($this->once())->method('fetchOne')->willReturn(0);

        $this->expectException(Exception::class);

        // Update query
        $this->repository->updateTrainingCategory($this->entity);
    }
}
