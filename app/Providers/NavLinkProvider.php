<?php

namespace App\Providers;

use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class NavLinkProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FacadesView::composer('layouts.navigation', function (View $view) {
            return $view->with('navLinks', [
                'person.index' => 'People',
                'show.index' => 'Shows',
                'Training' => [
                    'trainingCategory.index' => 'Categories',
                    'trainingItem.index' => 'Items',
                    'trainingSession.index' => 'Sessions',
                ],
            ]);
        });
    }
}