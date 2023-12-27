<?php

declare(strict_types=1);

namespace App\Domain\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;

final class TrainingCategoryEntity
{
    public function __construct(
        public TrainingCategoryId $id,
        public string $name,
    ) {
    }
}
