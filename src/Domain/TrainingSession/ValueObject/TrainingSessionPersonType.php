<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession\ValueObject;

enum TrainingSessionPersonType: string
{
    case TYPE_TRAINER = 'trainer';
    case TYPE_TRAINEE = 'trainee';
}
