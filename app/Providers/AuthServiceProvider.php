<?php

namespace App\Providers;

use App\Permission;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

            //    comment out below foreach before running composer install/update or a migration
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {

                return $user->hasRole($permission->roles);

            });
        }
    }
    //    comment out below function before running composer install/update or a migration
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
