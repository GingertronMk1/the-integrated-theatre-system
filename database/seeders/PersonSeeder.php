<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * @throws \JsonException
     * @throws \RuntimeException
     */
    public function run(): void
    {
        $shows = HistoryData::shows();
        $years = [];

        foreach ($shows as $show) {
            foreach (array_merge($show['cast'], $show['crew']) as $credit) {
                $name = $credit['name'];
                $years[$name] ??= [$show['year'], $show['year']];
                $years[$name][0] = min($years[$name][0], $show['year']);
                $years[$name][1] = max($years[$name][1], $show['year']);
            }
        }

        $people = Person::query()->get()->keyBy('name');
        foreach ($years as $name => [$firstYear, $lastYear]) {
            $person = $people->get($name);
            if ($person === null) {
                Person::query()->create(['name' => $name, 'start_year' => $firstYear, 'end_year' => $lastYear]);
            } else {
                $person->update(['start_year' => $firstYear, 'end_year' => $lastYear]);
            }
        }
    }
}
