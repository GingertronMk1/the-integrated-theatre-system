<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Application\Common\Service\ClockInterface;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalTrainingCategoryRepository extends AbstractDbalRepository implements TrainingCategoryRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): TrainingCategoryId
    {
        return TrainingCategoryId::generate();
    }

    protected function getTable(): string
    {
        return 'training_categories';
    }

    public function save(TrainingCategoryEntity $category): void
    {
        $count = $this->getCount($this->connection, $category->id);

        $qb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $qb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } else {
            $qb
                ->update($this->getTable())
                ->set('name', ':name')
                ->set('created_at', ':now')
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        }
        $qb->setParameters([
            'id' => (string) $category->id,
            'name' => $category->name,
            'now' => (string) $this->clock->getCurrentTime(),
        ])
        ->executeQuery()
        ;
    }
}
