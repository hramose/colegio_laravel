<?php

use Illuminate\Database\Seeder;
use App\App\Entities\Materia;

class MateriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materias = [
        	'Matemáticas',
    		'Idioma Español',
    		'Ciencias Naturales',
    		'Estudios Sociales',
    		'Fisica Fundamental',
    		'Educación Física',
    		'Programación',
    		'Computación'
        ];
        foreach($materias as $index => $materia){
        	Materia::create([
        		'descripcion' => $materia,
        		'orden' => $index,
        		'estado' => 'A',
        		'created_by' => 'admin',
	        	'updated_by' => 'admin'
        	]);
        }
    }
}
