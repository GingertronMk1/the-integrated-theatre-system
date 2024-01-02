<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

final readonly class TrainingCategoryModel
{
    public function __construct(
        public TrainingCategoryId $id,
        public string $name,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}
