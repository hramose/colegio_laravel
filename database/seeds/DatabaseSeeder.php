<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Persona;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
        	$this->call(PerfilTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(CicloTableSeeder::class);
            $this->call(MateriaTableSeeder::class);
            $this->call(GradoTableSeeder::class);
            $this->call(TipoActividadTableSeeder::class);
            $this->call(ModuloTableSeeder::class);
            $this->call(VistaPermisoTableSeeder::class);
            $this->call(PlantillaUnidadTableSeeder::class);

            $maestros = factory(\App\App\Entities\Persona::class, 10)
            					->states('maestro')->create();

            $estudiantes = factory(\App\App\Entities\Persona::class, 100)
                                ->states('estudiante')->create();
            
        }
        catch(\Exception $ex)
        {
            dd($ex);
        }
    }
}
