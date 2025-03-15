<?php

namespace App\Console\Commands;

use App\Models\CastMember;
use App\Models\CrewMember;
use App\Models\CrewRole;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use App\Models\Venue;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class ImportFromNNTHistorySite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-nnt-history-site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private const string HISTORY_SITE_BASE_URL = 'https://history.newtheatre.org.uk';

    private const string SEARCH_FEED = self::HISTORY_SITE_BASE_URL.'/feeds/search.json';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $resp = Cache::remember(
            self::SEARCH_FEED,
            $this->getCacheExpiry(),
            fn () => Http::get(self::SEARCH_FEED)->json()
        );
        $this->info('Importing people');
        $peopleArray = array_filter($resp, fn (array $item) => $item['type'] === 'person');
        $peopleProgress = $this->createProgressBar($peopleArray);
        foreach ($peopleArray as $inputPerson) {
            $person = Person::create([
                'name' => $inputPerson['title'],
                'end_year' => $inputPerson['graduated'],
                'legacy_link' => $inputPerson['link'],
            ]);

            if (isset($inputPerson['link'])) {
                $personCacheHit = Cache::get($inputPerson['link']);
                $peopleProgress->setMessage(sprintf(
                    '%s hit for %s',
                    $personCacheHit ? 'Cache' : 'No cache',
                    $inputPerson['link']
                ));
                $personPage = Cache::remember(
                    $inputPerson['link'],
                    $this->getCacheExpiry(),
                    fn () => Http::get(self::HISTORY_SITE_BASE_URL.$inputPerson['link'])->body()
                );
                $personCrawler = new Crawler($personPage);

                try {
                    $person->bio = $personCrawler->filter('.person-bio')->text();
                    $person->save();
                } catch (Throwable) {
                    // Ignore...
                }
            }
            $peopleProgress->advance();
        }
        $peopleProgress->finish();
        $this->newLine();

        $this->info('Importing shows');
        $inputShows = array_filter($resp, fn (array $item) => $item['type'] === 'show');
        $showProgress = $this->createProgressBar($inputShows);
        foreach ($inputShows as $inputShow) {
            $show = new Show([
                'title' => $inputShow['title'],
                'blurb' => $inputShow['content'],
                'legacy_link' => $inputShow['link'] ?? null,
                'season_id' => Season::query()->firstOrCreate(['name' => $inputShow['season']]),
                'playwright_id' => Playwright::query()->firstOrCreate(['name' => $inputShow['playwright'] ?? $inputShow['playwright_formatted'] ?? 'Unknown'])->id,
                'venue_id' => Venue::query()->firstOrCreate(['name' => $inputShow['venue'] ?? 'Unknown'])->id,
            ]);

            try {
                $show->year = (int) substr($inputShow['year_title'], 0, 4);
            } catch (Throwable) {
                // Don't bother
            }

            $show->save();

            if ($inputShow['link']) {
                $showCacheHit = Cache::get($inputShow['link']);
                $showProgress->setMessage(sprintf(
                    '%s hit for %s',
                    $showCacheHit ? 'Cache' : 'No cache',
                    $inputShow['link']
                ));
                $showPage = Cache::remember(
                    $inputShow['link'],
                    $this->getCacheExpiry(),
                    fn () => Http::get(self::HISTORY_SITE_BASE_URL.$inputShow['link'])->body()
                );
                $showCrawler = new Crawler($showPage);
                $showCrawler->filter('.show-cast .person-list .person-single a')->each(
                    function (Crawler $node) use ($show) {
                        $person = Person::query()->where('legacy_link', '=', $node->attr('href'))->firstOrFail();
                        CastMember::create([
                            'show_id' => $show->id,
                            'person_id' => $person->id,
                            'role_name' => $node->filter('.person-role')->text(),
                        ]);
                    });

                $showCrawler->filter('.show-crew .person-list .person-single a')->each(
                    function (Crawler $node) use ($show) {
                        $person = Person::query()->where('legacy_link', '=', $node->attr('href'))->firstOrFail();
                        $role = $node->filter('.person-role')->text();
                        CrewMember::create([
                            'show_id' => $show->id,
                            'person_id' => $person->id,
                            'crew_role_id' => CrewRole::query()->firstOrCreate(['name' => $role])->id,
                        ]);
                    });
            }
            $showProgress->advance();
        }
        $showProgress->finish();

        return self::SUCCESS;
    }

    private function getCacheExpiry(): CarbonInterface
    {
        return now()->addMonth();
    }

    private function createProgressBar(int|array $n): ProgressBar
    {
        $n = is_int($n) ? $n : count($n);
        $progressBar = $this->output->createProgressBar($n);
        $progressBar->setMessage('');
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:16s%/%estimated:-16s% %message%');
        $progressBar->start();

        return $progressBar;
    }
}
