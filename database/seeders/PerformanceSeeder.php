<?php

namespace Database\Seeders;

use App\Models\Performance;
use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use App\Models\Venue;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class PerformanceSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([VenueSeeder::class, ShowSeeder::class]);

        $shows = Show::query()->get()->keyBy(fn (Show $show): string => $this->showKey($show->name, $show->year ?? '', $show->season_id, $show->playwright_id));
        $playwrights = Playwright::query()->get()->keyBy('name');
        $seasons = Season::query()->get()->keyBy('name');
        $venues = Venue::query()->get()->keyBy('name');

        foreach (HistoryData::shows() as $record) {
            $playwright = $record['playwright'] !== '' ? $record['playwright'] : 'Unknown';
            $season = $record['season'] !== '' ? $record['season'] : 'Unknown';
            $playwrightId = ($playwrights->get($playwright) ?? throw new \RuntimeException('Missing archive playwright: '.$playwright))->id;
            $seasonId = ($seasons->get($season) ?? throw new \RuntimeException('Missing archive season: '.$season))->id;
            $show = $shows->get($this->showKey($record['title'], $record['year'], $seasonId, $playwrightId));
            if ($show === null) {
                throw new \RuntimeException('Missing archive show: '.$record['title']);
            }

            $venueName = $record['venue'] !== '' ? $record['venue'] : 'Unknown';
            $venue = $venues->get($venueName);
            if ($venue === null) {
                $venue = Venue::query()->firstOrCreate(['name' => $venueName], ['address' => '', 'description' => '']);
                $venues->put($venueName, $venue);
            }

            $startDate = $record['date_start'] !== '' ? $record['date_start'] : $record['date_end'];
            $start = $this->date($startDate, $record['year']);
            $end = $record['date_start'] !== '' && $record['date_end'] !== '' ? $this->date($record['date_end'], $record['year']) : $start;
            if ($end->lessThan($start)) {
                $end = $start;
            }

            for ($day = $start; $day->lessThanOrEqualTo($end); $day = $day->addDay()) {
                Performance::query()->firstOrCreate([
                    'show_id' => $show->id,
                    'venue_id' => $venue->id,
                    'show_start' => $day->setTime(19, 30),
                ], ['capacity' => 100]);
            }
        }
    }

    private function date(string $date, string $year): CarbonImmutable
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) === 1) {
            return CarbonImmutable::parse($date)->startOfDay();
        }

        if (preg_match('/^\d{4}-\d{2}$/', $date) === 1) {
            return CarbonImmutable::parse($date.'-01')->startOfDay();
        }

        return CarbonImmutable::createFromDate((int) $year, 1, 1)->startOfDay();
    }

    private function showKey(string $name, string $year, string $season, string $playwright): string
    {
        return json_encode([$name, $year, $season, $playwright], JSON_THROW_ON_ERROR);
    }
}
