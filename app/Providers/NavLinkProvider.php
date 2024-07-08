<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;

class NavLinkProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
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
    }
}
