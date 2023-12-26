<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Application\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingItemRepository implements TrainingItemRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function createTrainingItem(string $name, bool $isDangerous, TrainingCategoryId $trainingCategoryId): void
    {
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
                'id' => (string) TrainingItemId::generate(),
                'name' => $name,
                'is_dangerous' => (int) $isDangerous,
                'training_category_id' => (string) $trainingCategoryId,
                'now' => (new DateTimeImmutable())->format('c'),
            ])
            ->executeQuery()
        ;
    }
}
