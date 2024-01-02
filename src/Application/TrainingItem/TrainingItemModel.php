<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use DateTimeImmutable;

final readonly class TrainingItemModel
{
    public function __construct(
        public TrainingItemId $id,
        public string $name,
        public bool $isDangerous,
        public TrainingCategoryId $trainingCategoryId,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}
