<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Grado;

class GradoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grados = array(
        	['Primero Primaria',1,'P'],
        	['Segundo Primaria',2,'P'],
        	['Tercero Primaria',3,'P'],
        	['Cuarto Primaria',4,'P'],
        	['Quinto Primaria',5,'P'],
        	['Sexto Primaria',6,'P']
        );
        
		foreach($grados as $grado){
			Grado::create([
				'descripcion' => $grado[0],
				'numero' => $grado[1],
				'nivel_academico' => $grado[2],
				'estado' => 'A',
				'created_by' => 'admin',
		    	'updated_by' => 'admin'
			]);
        }
    }
}
