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
    protected $signature = 'app:check-crew-roles {min-percent=90} {--replace}';

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
        if ($this->option('replace')) {
            $toReplace = $this->ask('Enter the IDs of the roles you want replacing, separated by commas');
            $replaceWith = $this->ask('Enter the ID with which to replace them');
            $replaced = CrewMember::query()
                ->whereIn(
                    'id',
                    array_map(
                        fn (string $id) => intval($id),
                        explode(',', $toReplace)
                    )
                )
                ->update([
                    'crew_role_id' => $replaceWith,
                ]);
            $this->info("Updated {$replaced} records");
        }

        $json = [];
        $setRoles = CrewMember::query()->pluck('id');
        $this->withProgressBar(CrewMember::all(), function ($member) use (&$json, $setRoles) {
            $role = $member->crewRole;
            $key = "{$role->id}-{$role->name}";
            if (isset($json[$key])) {
                return;
            }
            $json[$key] = [];
            foreach (CrewRole::query()
                ->whereNot('id', '=', $role->id)
                ->whereIn('id', $setRoles)
                ->get() as $compRole) {
                if (
                    in_array(
                        $compRole->id,
                        array_column(
                            array_merge([...array_values($json)]),
                            'id'
                        )
                    )
                ) {
                    continue;
                }
                similar_text($role->name, $compRole->name, $percent);
                if ($percent >= $this->argument('min-percent')) {
                    $json[$key][] = ['id' => $compRole->id, 'name' => $compRole->name, 'diff' => $percent];
                }
            }
        });

        foreach ($json as $role => $comparators) {
            $newVal = $comparators;
            usort($newVal, fn ($first, $second) => $second['diff'] <=> $first['diff']);
            $json[$role] = $newVal;
        }

        $json = array_filter($json, fn (array $arr) => count($arr) > 0);

        uasort($json, fn (array $a, array $b) => count($b) <=> count($a));

        echo json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('comparison.json', json_encode($json, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
