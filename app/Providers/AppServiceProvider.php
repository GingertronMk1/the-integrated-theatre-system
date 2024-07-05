<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
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
        Model::preventAccessingMissingAttributes();

        FacadesView::composer('layouts.navigation', function(View $view) {
            return $view->with('navLinks', [
                'dashboard' => 'Dashboard',
                'person.index' => 'People',
                'trainingCategory.index' => 'Training Categories',
                'trainingItem.index' => 'Training Items',
            ]);
        });
    }
}
