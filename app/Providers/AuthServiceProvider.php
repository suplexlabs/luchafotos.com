<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Event;
use App\Models\Group;
use App\Models\Link;
use App\Models\Source;
use App\Models\Topic;
use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => AdminPolicy::class,
        Company::class => AdminPolicy::class,
        Event::class => AdminPolicy::class,
        Group::class => AdminPolicy::class,
        Link::class => AdminPolicy::class,
        Source::class => AdminPolicy::class,
        Topic::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
