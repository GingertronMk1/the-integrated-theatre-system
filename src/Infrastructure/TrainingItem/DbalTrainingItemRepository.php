<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemException;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;

final readonly class DbalTrainingItemRepository implements TrainingItemRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getNextId(): TrainingItemId
    {
        return TrainingItemId::generate();
    }

    public function createTrainingItem(TrainingItemEntity $entity): void
    {
        try {
            $qb = $this->connection->createQueryBuilder();
            $qb
                ->insert('training_items')
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'is_dangerous' => ':is_dangerous',
                    'training_category_id' => ':training_category_id',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ])
                ->setParameters([
                    'id' => $entity->id,
                    'name' => $entity->name,
                    'is_dangerous' => (int) $entity->isDangerous,
                    'training_category_id' => (string) $entity->trainingCategoryId,
                    'now' => (new DateTimeImmutable())->format('c'),
                ])
                ->executeQuery()
            ;
        } catch (Exception $e) {
            throw TrainingItemException::errorSaving($e);
        }
    }
}
