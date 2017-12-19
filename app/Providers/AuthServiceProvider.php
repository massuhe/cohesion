<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('tiene-permiso', function($user, $permiso){
            $user->load(['rol.permisos']);
            $permisos = collect($user->rol->permisos->map(function ($p) {
                return $p->only('nombre');
            }))->flatten();
            return $permisos->contains($permiso);
        });
    }
}
