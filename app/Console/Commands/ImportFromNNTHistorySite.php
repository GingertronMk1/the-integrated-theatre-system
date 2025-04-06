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
use Carbon\CarbonPeriodImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class ImportFromNNTHistorySite extends Command
{
    private const string HISTORY_SITE_BASE_URL = 'https://history.newtheatre.org.uk';

    private const string SEARCH_FEED = self::HISTORY_SITE_BASE_URL.'/feeds/search.json';

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
        usort($peopleArray, fn (array $a, array $b) => strcmp($a['link'] ?? '', $b['link'] ?? ''));
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
        usort($inputShows, fn ($a, $b) => strcmp($a['link'] ?? '', $b['link'] ?? ''));
        $showProgress = $this->createProgressBar($inputShows);
        foreach ($inputShows as $inputShow) {
            $show = new Show([
                'title' => $inputShow['title'],
                'blurb' => $inputShow['content'],
                'legacy_link' => $inputShow['link'] ?? null,
                'season_id' => Season::query()->firstOrCreate(['name' => $inputShow['season']])->id,
                'playwright_id' => Playwright::query()->firstOrCreate(['name' => $inputShow['playwright'] ?? $inputShow['playwright_formatted'] ?? 'Unknown'])->id,
            ]);

            try {
                $show->year = (int) substr($inputShow['year_title'], 0, 4);
            } catch (Throwable) {
                // Don't bother
            }

            $show->save();

            if (isset($inputShow['venue'])) {
                $venue = Venue::query()->firstOrCreate(['name' => $inputShow['venue']]);

                $performancesCreated = false;

                if (! empty($inputShow['run'])) {
                    try {
                        $format = 'Y F d';
                        $run = str_replace(['&nbsp;', '&ndash;'], [' ', '-'], $inputShow['run']);
                        if (preg_match('/(\d+) (\w+)-(\d+) (\w+) (\d+)/', $run, $matches)) {
                            [, $start, $startMonth, $end, $endMonth, $year] = $matches;
                            $end = empty($end) ? $start : $end;
                            if (Carbon::canBeCreatedFromFormat("{$year} {$startMonth} {$start}", $format)) {
                                $startDate = Carbon::createFromFormat($format, "{$year} {$startMonth} {$start}");
                                $endDate = Carbon::createFromFormat($format, "{$year} {$endMonth} {$end}");
                                foreach (CarbonPeriodImmutable::create($startDate, $endDate) as $date) {
                                    $show->performances()->create([
                                        'show_date' => $date,
                                        'venue_id' => $venue->id,
                                    ]);
                                }
                                $performancesCreated = true;
                            }
                        } elseif (preg_match('/(\d+)(-\d+)? (\w+) (\d+)/', $run, $matches)) {
                            [, $start, $end, $month, $year] = $matches;
                            $end = empty($end) ? $start : $end;
                            if (Carbon::canBeCreatedFromFormat("{$year} {$month} {$start}", $format)) {
                                $startDate = Carbon::createFromFormat($format, "{$year} {$month} {$start}");
                                $endDate = Carbon::createFromFormat($format, "{$year} {$month} {$end}");
                                foreach (CarbonPeriodImmutable::create($startDate, $endDate) as $date) {
                                    $show->performances()->create([
                                        'show_date' => $date,
                                        'venue_id' => $venue->id,
                                    ]);
                                }
                                $performancesCreated = true;
                            }
                        }
                    } catch (Throwable) {
                        // Ignore
                    }
                }
                if (! $performancesCreated) {
                    $date = $inputShow['date'] ?? null;
                    if (Carbon::canBeCreatedFromFormat($date, 'Y-m-d')) {
                        $date = Carbon::createFromFormat('Y-m-d', $inputShow['date']);
                        $show->performances()->create([
                            'show_date' => $date,
                            'venue_id' => $venue->id,
                        ]);
                    } else {
                        Log::error("Could not create a Carbon instance for {$date}");
                    }
                }
            }

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
