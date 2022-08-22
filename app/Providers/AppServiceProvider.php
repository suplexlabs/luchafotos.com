<?php

namespace App\Providers;

use App\Models\EventTicketDetail;
use App\Models\Link;
use App\Models\Source;
use App\Models\Event;
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
        Relation::morphMap([
            'link'                => Link::class,
            'source'              => Source::class,
            'event'               => Event::class,
            'event_ticket_detail' => EventTicketDetail::class,
        ]);
    }
}
