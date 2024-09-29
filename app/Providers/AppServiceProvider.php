<?php

namespace App\Providers;

use App\Search\News;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Algolia\ScoutExtended\Searchable\Aggregator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        News::bootSearchable();
    }
}