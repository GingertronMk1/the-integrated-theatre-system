<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * @throws \JsonException
     * @throws \RuntimeException
     */
    public function run(): void
    {
        $shows = HistoryData::shows();
        $names = [];
        foreach ($shows as $show) {
            $name = $show['season'] !== '' ? $show['season'] : 'Unknown';
            $names[$name] = true;
        }

        foreach (array_keys($names) as $name) {
            Season::query()->firstOrCreate(['name' => $name], ['description' => '', 'colour' => '#000000']);
        }
    }
}
