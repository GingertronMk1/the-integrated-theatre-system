<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Model::shouldBeStrict();

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
