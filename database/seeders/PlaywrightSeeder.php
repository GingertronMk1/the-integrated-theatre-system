<?php

namespace Database\Seeders;

use App\Models\Playwright;
use Illuminate\Database\Seeder;

class PlaywrightSeeder extends Seeder
{
    public function run(): void
    {
        $shows = HistoryData::shows();
        $names = [];
        foreach ($shows as $show) {
            $name = $show['playwright'] !== '' ? $show['playwright'] : 'Unknown';
            $names[$name] = true;
        }

        foreach (array_keys($names) as $name) {
            Playwright::query()->firstOrCreate(['name' => $name], ['bio' => '', 'external_links' => []]);
        }
    }
}
