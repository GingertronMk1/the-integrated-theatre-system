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
    protected $description = 'Create a model with all the trimmings, views, and a form component';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('modelName');
        $modelNameLC = lcfirst($modelName);

        foreach ($this->getThingsToMake($modelName) as $makeCommand => $arguments) {
            $this->call(
                "make:{$makeCommand}",
                $arguments
            );
        }

        foreach ($this->getViews() as $viewName) {
            $this->call(
                'make:view',
                [
                    'name' => "pages/{$modelNameLC}/{$viewName}",
                ]
            );
        }

        $this->call('make:component', ['name' => "Form/{$modelName}Form"]);
    }

    private function getViews(): array
    {
        return [
            'index',
            'create',
            'edit',
            'show',
        ];
    }

    private function getThingsToMake(string $modelName): array
    {
        return [
            'model' => [
                'name' => $modelName,
                '--factory' => true,
                '--migration' => true,
                '--phpunit' => true,
                '--policy' => true,
                '--requests' => true,
            ],
            'controller' => [
                'name' => "{$modelName}Controller",
                '--model' => $modelName,
                '--phpunit' => true,
            ],
        ];
    }
}
