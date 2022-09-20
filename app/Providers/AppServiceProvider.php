<?php

namespace App\Providers;

use App\Models\Source;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Nuwave\Lighthouse\Support\Contracts\CreatesContext::class,
            \App\GraphQL\Contexts\AppContextFactory::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
