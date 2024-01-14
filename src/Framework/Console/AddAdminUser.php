<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[
    AsCommand(
        name: 'app:add-admin-user',
        description: 'Adds the admin user, if they do not already exist'
    )
]
final class AddAdminUser extends Command
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->userRepository->save($this->getAdminUser());
            $io->success('Successfully created');

        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function getAdminUser(): UserEntity
    {
        return new UserEntity(
            id: UserId::fromString('018d0815-3c23-7710-bab2-3aa0fe6fcad3'),
            email: 'admin@tits.test',
            password: 'qwertyuiop',
            roles: []
        );
    }
}
