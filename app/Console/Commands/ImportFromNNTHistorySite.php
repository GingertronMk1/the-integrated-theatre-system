<?php

namespace App\Console\Commands;

use App\Models\CastMember;
use App\Models\CrewMember;
use App\Models\CrewRole;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
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
        $resp = Http::get(self::SEARCH_FEED)->json();
        $this->info('Importing people');
        $this->withProgressBar(
            array_filter($resp, fn (array $item) => $item['type'] === 'person'),
            function (array $person) use (&$people) {
                Person::create([
                    'name' => $person['title'],
                    'end_year' => $person['graduated'],
                    'legacy_link' => $person['link'],
                ]);
            });

        $this->info('Importing shows');
        $inputShows = array_filter($resp, fn (array $item) => $item['type'] === 'show');
        foreach ($inputShows as $n => $inputShow) {
            $this->output->section(sprintf('%s/%s %s', $n, count($inputShows), $inputShow['title']));
            $show = new Show([
                'title' => $inputShow['title'],
                'blurb' => $inputShow['content'],
            ]);

            try {
                $show->year = Carbon::createFromFormat('Y-m-d', $inputShow['year'])->format('Y');
            } catch (Throwable) {
                // Don't bother
            }

            $season = Season::query()->firstOrCreate(['name' => $inputShow['season']]);
            $show->season_id = $season->id;

            $playwright = Playwright::query()->firstOrCreate(['name' => $inputShow['playwright'] ?? $inputShow['playwright_formatted'] ?? 'Unknown']);
            $show->playwright_id = $playwright->id;

            $show->save();

            if ($inputShow['link']) {
                $this->info('Adding cast and crew');
                $showPage = Http::get(self::HISTORY_SITE_BASE_URL.$inputShow['link']);
                $showCrawler = new Crawler($showPage->body());
                $showCrawler->filter('.show-cast .person-list .person-single a')->each(
                    function (Crawler $node) use ($show) {
                        $person = Person::query()->where('legacy_link', '=', $node->attr('href'))->firstOrFail();
                        $this->info($person->name);
                        $this->info($node->attr('href'));
                        CastMember::create([
                            'show_id' => $show->id,
                            'person_id' => $person->id,
                            'role_name' => $node->filter('.person-role')->text(),
                        ]);
                    });

                $showCrawler->filter('.show-crew .person-list .person-single a')->each(
                    function (Crawler $node) use ($show) {
                        $person = Person::query()->where('legacy_link', '=', $node->attr('href'))->firstOrFail();
                        $this->info($person->name);
                        $this->info($node->attr('href'));
                        $role = $node->filter('.person-role')->text();
                        CrewMember::create([
                            'show_id' => $show->id,
                            'person_id' => $person->id,
                            'crew_role_id' => CrewRole::query()->firstOrCreate(['name' => $role])->id,
                        ]);
                    });
            }
        }

        return self::SUCCESS;
    }
}
