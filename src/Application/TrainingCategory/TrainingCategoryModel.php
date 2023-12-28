<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;

final readonly class TrainingCategoryModel
{
    public function __construct(
        public TrainingCategoryId $id,
        public string $name,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {
    }
}
