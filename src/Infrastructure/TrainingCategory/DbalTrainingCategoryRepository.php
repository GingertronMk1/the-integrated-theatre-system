<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryException;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;

final readonly class DbalTrainingCategoryRepository implements TrainingCategoryRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getNextId(): TrainingCategoryId
    {
        return TrainingCategoryId::generate();
    }

    public function createTrainingCategory(TrainingCategoryEntity $category): void
    {
        try {

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('training_categories')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'created_at' => ':created_at',
                'updated_at' => ':updated_at',
            ])
            ->setParameters([
                'id' => (string) $category->id,
                'name' => $category->name,
                'created_at' => (new DateTimeImmutable())->format('c'),
                'updated_at' => (new DateTimeImmutable())->format('c'),
            ])
            ->executeQuery()
        ;
        } catch (Exception $e) {
            throw TrainingCategoryException::errorSaving($e);
        }
    }

    public function updateTrainingCategory(TrainingCategoryEntity $category): void
    {
        try {

        $finderQB = $this->connection->createQueryBuilder();
        $result = $finderQB
            ->select('COUNT(*)')
            ->from('training_categories')
            ->where('id = :id')
            ->setParameter('id', (string) $category->id)
            ->fetchOne()
        ;
        if ((int) $result < 1) {
            throw TrainingCategoryException::notFound($category->id);
        }

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->update('training_categories')
            ->set('name', ':name')
            ->set('updated_at', ':now')
            ->setParameters([
                'id' => (string) $category->id,
                'name' => $category->name,
                'now' => (new DateTimeImmutable())->format('c'),
            ])
            ->where('id = :id')
            ->executeQuery()
        ;
        } catch (Exception $e) {
            throw TrainingCategoryException::errorSaving($e);
        }
    }
}
