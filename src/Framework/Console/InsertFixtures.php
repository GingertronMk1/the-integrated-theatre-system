<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:insert-fixtures',
    description: 'Adds fixtures to DB'
)]
final class InsertFixtures extends Command
{
    private const ADMIN_ID = '018cb55d-f88d-70b3-bd5c-3771b1849848';

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);
        foreach ($this->getUsers() as $user) {
            $style->section("Creating user with email `{$user->email}`...");
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $user->getPassword());
            $this->userRepository->createUser(new UserEntity(
                $user->id,
                $user->email,
                $user->roles,
                $hashedPassword
            ));
            $style->writeln('Done');
        }

        return Command::SUCCESS;
    }

    /**
     * @return array<int, UserEntity>
     */
    private function getUsers(): array
    {
        return [
          new UserEntity(
              UserId::fromString(self::ADMIN_ID),
              'admin@tits.test',
              [],
              'test'
          ),
          ];
    }
}
