<?php

namespace App\Providers;

use App\Filter\FilterManager;
use App\Filter\Filters\CategoryFilter;
use App\Filter\Filters\CountryFilter;
use App\Filter\Filters\SelectionFilter;
use App\Filter\Filters\PriceFilter;
use Illuminate\Support\ServiceProvider;

class FiltersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            //new PriceFilter(),
            new CategoryFilter(),
            new SelectionFilter(),
            new CountryFilter()
        ]);
    }
}
