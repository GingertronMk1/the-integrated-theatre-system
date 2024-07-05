<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventAccessingMissingAttributes();

        FacadesView::composer('layouts.navigation', function (View $view) {
            return $view->with('navLinks', [
                'dashboard' => 'Dashboard',
                'person.index' => 'People',
                'trainingCategory.index' => 'Training Categories',
                'trainingItem.index' => 'Training Items',
                'trainingSession.index' => 'Training Sessions',
                'show.index' => 'Shows',
            ]);
        });

        Blade::directive('toparagraphs', function (string $expression): string {
            return <<<PHP
            <?php
                foreach(explode(PHP_EOL, $expression) as \$paragraph) {
                    if (!empty(\$paragraph)) {
                        echo '<p>'.e(\$paragraph).'</p>';
                    }
                }
            ?>
            PHP;

        });
    }
}
