<?php

namespace App\Console\Commands;

use App\Models\CrewMember;
use App\Models\CrewRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckCrewRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-crew-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = [];
        $this->withProgressBar(CrewRole::all(), function ($role) use (&$json) {
            $key = "{$role->id}-{$role->name}";
            $json[$key] = [];
            foreach (CrewRole::query()->whereNot('id', '=', $role->id)->get() as $compRole) {
                if (in_array($compRole->id, array_column(array_merge([...array_values($json)]), 'id'))) {
                    continue;
                }
                similar_text($role->name, $compRole->name, $percent);
                if ($percent >= 80) {
                    $json[$key][] = [...$compRole->toArray(), 'diff' => $percent];
                }
            }
        });

        foreach ($json as $role => $comparators) {
            $newVal = $comparators;
            usort($newVal, fn ($first, $second) => $second['diff'] <=> $first['diff']);
            $json[$role] = $newVal;
        }

        $json = array_filter($json, fn (array $arr) => count($arr));

        uasort($json, fn (array $a, array $b) => count($b) <=> count($a));

        echo json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('comparison.json', json_encode($json, JSON_PRETTY_PRINT));
        return self::SUCCESS;

    }
}
