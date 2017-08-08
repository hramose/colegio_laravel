<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\App\Entities\User;

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

        Gate::define('is_super_admin', function(User $user){
            return $user->id == 1;
        });

        Gate::define('edit_super_admin', function(User $user, User $other){
            if($user->id == 1)
                return true;
            else
                if($other->id != 1)
                    return true;
            return false;
        });

        Gate::define('entregar_actividad', function ($user, $actividad) {
            if($actividad->entrega_via_web){

                $timeActual = time();
                $timeFechaInicio = strtotime($actividad->fecha_inicio);
                $timeFechaEntrega = strtotime($actividad->fecha_entrega);
                if($timeFechaInicio < $timeActual && $timeActual <= $timeFechaEntrega)
                    return true;
                else
                    return false;
            }
            else{
                return false;
            }

        });
    }
}
