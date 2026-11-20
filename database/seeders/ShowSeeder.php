<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Playwright;
use App\Models\Role;
use App\Models\Season;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        $shows = HistoryData::shows();
        $this->call([PersonSeeder::class, PlaywrightSeeder::class, SeasonSeeder::class]);

        $people = Person::query()->get()->keyBy('name');
        $playwrights = Playwright::query()->get()->keyBy('name');
        $seasons = Season::query()->get()->keyBy('name');
        $roles = Role::query()->get()->keyBy('name');

        foreach ($shows as $record) {
            $playwrightName = $record['playwright'] !== '' ? $record['playwright'] : 'Unknown';
            $seasonName = $record['season'] !== '' ? $record['season'] : 'Unknown';
            $playwright = $playwrights->get($playwrightName);
            if ($playwright === null) {
                $playwright = Playwright::query()->create(['name' => $playwrightName, 'bio' => '', 'external_links' => []]);
                $playwrights->put($playwrightName, $playwright);
            }
            $season = $seasons->get($seasonName);
            if ($season === null) {
                $season = Season::query()->create(['name' => $seasonName, 'description' => '', 'colour' => '#000000']);
                $seasons->put($seasonName, $season);
            }

            $show = Show::query()->firstOrCreate([
                'name' => $record['title'],
                'year' => $record['year'],
                'season_id' => $season->id,
                'playwright_id' => $playwright->id,
            ]);

            foreach ($record['cast'] as $sort => $credit) {
                ShowCast::query()->firstOrCreate([
                    'show_id' => $show->id,
                    'person_id' => ($people->get($credit['name']) ?? throw new \RuntimeException('Missing credited person.'))->id,
                    'role_name' => $credit['role'],
                ], ['sort' => $sort, 'notes' => $credit['note'] ?: null]);
            }

            foreach ($record['crew'] as $credit) {
                $roleName = $credit['role'] !== '' ? $credit['role'] : 'Unknown';
                $role = $roles->get($roleName);
                if ($role === null) {
                    $role = Role::query()->create(['name' => $roleName]);
                    $roles->put($roleName, $role);
                }
                ShowCrew::query()->firstOrCreate([
                    'show_id' => $show->id,
                    'person_id' => ($people->get($credit['name']) ?? throw new \RuntimeException('Missing credited person.'))->id,
                    'role_id' => $role->id,
                ], ['notes' => $credit['note'] ?: null]);
            }
        }
    }
}
