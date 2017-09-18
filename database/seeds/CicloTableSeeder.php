<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Ciclo;

class CicloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anioActual = intval( date('Y') );
        $anio = $anioActual - 1;

        for($i=0;$i<=2;$i++){
        	$ciclo = Ciclo::create([
	        	'descripcion' => $anio,
	        	'fecha_inicio' => $anio.'-01-01',
	        	'fecha_fin' => $anio.'-12-31',
	        	'actual' => $anio == $anioActual ? 1 : 0,
	        	'estado' => 'A',
	        	'created_by' => 'admin',
	        	'updated_by' => 'admin'
	        ]);
        	$anio++;
        }
    }
}
