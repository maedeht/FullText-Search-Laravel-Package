<?php

namespace Ninja\Search;

use Illuminate\Support\ServiceProvider;
use Ninja\Search\Repositories\Search;
use Ninja\Search\Repositories\ISearch;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ISearch::class, Search::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/config/search.php' =>  config_path('search.php'),
        ], 'config');
    }
}
