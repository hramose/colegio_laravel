<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\App\Entities\User;
use App\App\Repositories\PermisoRepo;

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

        Gate::define('permiso_ruta', function(User $user, $ruta){
            $permisoRepo = new PermisoRepo();
            return $permisoRepo->tienePermiso($user->perfil_id, $ruta);
        });

        Gate::define('calificar_actividad', function(User $user, $actividad){
            $unidadSeccion = $actividad->unidad_curso->unidad_seccion;
            return $unidadSeccion->estado == 'A';
        });

        Gate::define('permiso_seccion', function(User $user, $seccion)
        {
            return $user->persona_id == $seccion->maestro_id;
        });

        Gate::define('permiso_curso', function(User $user, $curso)
        {
            return $user->persona_id == $curso->maestro_id;
        });

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
