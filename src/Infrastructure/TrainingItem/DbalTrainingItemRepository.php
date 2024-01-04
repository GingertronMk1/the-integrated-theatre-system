<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Application\Common\Service\ClockInterface;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalTrainingItemRepository extends AbstractDbalRepository implements TrainingItemRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): TrainingItemId
    {
        return TrainingItemId::generate();
    }

    protected function getTable(): string
    {
        return 'training_items';
    }

    public function save(TrainingItemEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);
        $qb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $qb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'is_dangerous' => ':is_dangerous',
                    'training_category_id' => ':training_category_id',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } else {
            $qb
                ->update($this->getTable())
                ->set('name', ':name')
                ->set('is_dangerous', ':is_dangerous')
                ->set('training_category_id', ':training_category_id')
                ->set('updated_at', ':now')
                ->where('id = :id');
        }
        $qb->setParameters([
            'id' => $entity->id,
            'name' => $entity->name,
            'is_dangerous' => (int) $entity->isDangerous,
            'training_category_id' => (string) $entity->trainingCategoryId,
            'now' => (string) $this->clock->getCurrentTime(),
        ])
        ->executeQuery()
        ;
    }
}
