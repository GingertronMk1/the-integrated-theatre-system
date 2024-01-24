<?php

declare(strict_types=1);

namespace App\Framework\Console;

use App\Domain\CastMember\CastMemberEntity;
use App\Domain\CastMember\CastMemberRepositoryInterface;
use App\Domain\Common\ValueObject\Colour;
use App\Domain\CrewMember\CrewMemberEntity;
use App\Domain\CrewMember\CrewMemberRepositoryInterface;
use App\Domain\CrewRole\CrewRoleEntity;
use App\Domain\CrewRole\CrewRoleRepositoryInterface;
use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;
use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:import-history-site',
    description: 'Import data from the NNT History Project site',
)]
final class ImportFromHistorySite extends Command
{
    private readonly string $historySiteSearchUrl;
    private array $shows = [];
    private array $crewRoles = [];
    private array $seasons = [];
    private array $people = [];

    private readonly SymfonyStyle $io;

    public function __construct(
        private readonly string $historySiteBaseUrl,
        private readonly HttpClientInterface $client,
        private readonly ShowRepositoryInterface $showRepository,
        private readonly PersonRepositoryInterface $personRepository,
        private readonly CastMemberRepositoryInterface $castMemberRepository,
        private readonly CrewMemberRepositoryInterface $crewMemberRepository,
        private readonly SeasonRepositoryInterface $seasonRepository,
        private readonly CrewRoleRepositoryInterface $crewRoleRepository,
    ) {
        parent::__construct();
        $this->historySiteSearchUrl = "{$historySiteBaseUrl}/feeds/search.json";
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('memory_limit', '2048M');
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title("Importing from {$this->historySiteSearchUrl}");
        $progressBar = new ProgressBar($output);
        $progressBar->setMessage('');
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:16s%/%estimated:-16s% %memory:6s% %message%');
        $response = $this->client->request(
            'GET',
            $this->historySiteSearchUrl
        );
        $content = $response->toArray();

        $types = [];

        // $content = array_slice($content, 5, 5);

        // foreach ($progressBar->iterate($content) as $item) {
        foreach ($content as $item) {
            $types[$item['type']] = 1;
            $progressBar->setMessage("{$item['type']} {$item['title']}");
            switch ($item['type'] ?? '') {
                case 'show':
                    $this->saveShow($item);
            }
        }

        $this->io->listing(array_keys($types));

        return Command::SUCCESS;
    }

    private function saveShow(array $item): void
    {
        $seasonId = null;
        if (array_key_exists('season', $item)) {
            if (!array_key_exists($item['season'], $this->seasons)) {
                $seasonEntity = new SeasonEntity(
                    id: $this->seasonRepository->getNextId(),
                    name: $item['season'],
                    description: null,
                    colour: Colour::random()
                );
                $this->seasonRepository->save($seasonEntity);
                $this->seasons[$seasonEntity->name] = $seasonEntity;
            }
            $seasonId = $this->seasons[$item['season']]->id;
        }

        $showEntity = new ShowEntity(
            $this->showRepository->getNextId(),
            $item['title'],
            $item['excerpt'],
            html_entity_decode($item['year_title']),
            $seasonId
        );

        $this->showRepository->save($showEntity);
        $this->io->section("Saved show {$showEntity->name}");

        $showUrl = $this->historySiteBaseUrl.$item['link'];
        $showPage = $this->client->request(
            'GET',
            $showUrl
        );
        $crawler = new Crawler($showPage->getContent());

        $this->io->writeln("Saving cast for {$showEntity->name}");
        try {
            $cast = $crawler->filter('.show-cast .person-single');
            $cast->each(function (Crawler $castMember) use ($showEntity) {
                $castMemberLink = $castMember->filter('a')->first()->attr('href');
                if (!array_key_exists($castMemberLink, $this->people)) {
                    $personEntity = new PersonEntity(
                        $this->personRepository->getNextId(),
                        $castMember->filter('.person-name')->first()->text(),
                        null,
                        null,
                        null,
                        null,
                    );
                    // $this->io->writeln($personEntity->name);
                    $this->personRepository->save($personEntity);
                    $this->people[$castMemberLink] = $personEntity;
                } else {
                    $personEntity = $this->people[$castMemberLink];
                }
                $castMemberEntity = new CastMemberEntity(
                    $this->castMemberRepository->getNextId(),
                    $castMember->filter('.person-role')->first()->text(),
                    $personEntity->id,
                    $showEntity->id
                );
                $this->castMemberRepository->save($castMemberEntity);
            });
        } catch (Exception $e) {
            $this->io->error($e->getMessage());
        }

        $this->io->writeln("Saving crew for {$showEntity->name}");
        try {
            $crew = $crawler->filter('.show-crew .person-single');
            $crew->each(function (Crawler $crewMember) use ($showEntity) {
                $crewMemberLink = $crewMember->filter('a')->first()->attr('href');
                if (!array_key_exists($crewMemberLink, $this->people)) {
                    $personEntity = new PersonEntity(
                        $this->personRepository->getNextId(),
                        $crewMember->filter('.person-name')->first()->text(),
                        null,
                        null,
                        null,
                        null,
                    );
                    // $this->io->writeln($personEntity->name);
                    $this->personRepository->save($personEntity);
                    $this->people[$crewMemberLink] = $personEntity;
                } else {
                    $personEntity = $this->people[$crewMemberLink];
                }

                $crewRole = $crewMember->filter('.person-role')->first()->text();

                if (!array_key_exists($crewRole, $this->crewRoles)) {
                    $crewRoleEntity = new CrewRoleEntity(
                        $this->crewRoleRepository->getNextId(),
                        $crewRole,
                        null
                    );

                    $this->crewRoleRepository->save($crewRoleEntity);
                    $this->crewRoles[$crewRole] = $crewRoleEntity;
                }
                $crewMemberEntity = new CrewMemberEntity(
                    $this->crewMemberRepository->getNextId(),
                    $personEntity->id,
                    $this->crewRoles[$crewRole]->id,
                    '',
                    $showEntity->id
                );
                $this->crewMemberRepository->save($crewMemberEntity);
            });
        } catch (Exception $e) {
            $this->io->error($e->getMessage());
        }
    }
}
