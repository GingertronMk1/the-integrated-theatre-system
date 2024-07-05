<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-entity {modelName}';

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
        $modelName = $this->argument('modelName');
        $modelNameLC = lcfirst($modelName);

        $this->call(
            'make:model',
            [
                'name' => $modelName,
                '--all' => true,
                '--phpunit' => true,
            ]
        );
        foreach ([
            'index',
            'create',
            'edit',
            'show',
        ] as $viewName) {
            $this->call(
                'make:view',
                [
                    'name' => "pages/{$modelNameLC}/{$viewName}",
                ]
            );
        }

        $this->call('make:component', ['name' => "Form/{$modelName}Form"]);
    }
}
