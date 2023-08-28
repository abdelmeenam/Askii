<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user , $ability){
           return $user->type == 'super-admin' ??  true;
        });

        foreach (config('abilities') as $code => $label){
            Gate::define($code, function (User $user ) use ($code) {
                foreach ($user->roles as $role) {
                    if (in_array($code, $role->abilities)) {
                        return true;
                    }
                }
                return false;
            });
        }



    }
}
