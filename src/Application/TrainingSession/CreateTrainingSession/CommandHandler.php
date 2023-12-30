<?php

declare(strict_types=1);

namespace App\Application\TrainingSession\CreateTrainingSession;

use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingSessionRepositoryInterface $trainingSessionRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $id = $this->trainingSessionRepository->getNextId();
        echo sprintf('<pre>%s</pre>', print_r($command, true));
        exit;
    }
}
