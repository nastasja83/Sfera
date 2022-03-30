<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\User;
use App\Skill;
use App\Policies\UserPolicy;
use App\Policies\SkillPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Skill::class => SkillPolicy::class,
        Position::class => PositionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
