<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
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

    private const TRAINING_CATEGORY_IDS = [
      1 => '018cbad3-b98f-7974-846b-3a02b8333461',
    ];
    private const TRAINING_ITEM_IDS = [
      1 => '018cbad5-2cb4-75b8-be8f-e084403270d6',
    ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository,
        private TrainingItemRepositoryInterface $trainingItemRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);
        $style->section('Creating users');
        foreach ($this->getUsers() as $user) {
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $user->getPassword());
            $this->userRepository->createUser(new UserEntity(
                $user->id,
                $user->email,
                $user->roles,
                $hashedPassword
            ));
            $style->writeln("Created user with email `{$user->email}`");
        }

        $style->section('Creating training categories');
        foreach ($this->getTrainingCategories() as $category) {
            $this->trainingCategoryRepository->createTrainingCategory($category);
            $style->writeln("Created category with ID `{$category->id}`");
        }

        $style->section('Creating training items');
        foreach ($this->getTrainingItems() as $item) {
            $this->trainingItemRepository->createTrainingItem($item);
            $style->writeln("Created item with ID `{$item->id}`");
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

    /**
     * @return array<int, TrainingCategoryEntity>
     */
    private function getTrainingCategories(): array
    {
        return [
          new TrainingCategoryEntity(
              TrainingCategoryId::fromString(self::TRAINING_CATEGORY_IDS[1]),
              'Test Category 1',
          ),
        ];
    }

    /**
     * @return array<int, TrainingItemEntity>
     */
    private function getTrainingItems(): array
    {
        return [
          new TrainingItemEntity(
              TrainingItemId::fromString(self::TRAINING_CATEGORY_IDS[1]),
              'Test Item 1',
              true,
              TrainingCategoryId::fromString(self::TRAINING_CATEGORY_IDS[1]),
          ),
        ];
    }
}
