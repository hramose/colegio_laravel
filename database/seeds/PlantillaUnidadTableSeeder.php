<?php

use Illuminate\Database\Seeder;
use App\App\Entities\PlantillaUnidad;
use App\App\Entities\DetallePlantillaUnidad;

class PlantillaUnidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

    	$plantillas[0]['descripcion'] = '4 unidades, 25% c/u, se gana con 70pts.';
    	$plantillas[0]['unidades'] = array(['1',25,70],['2',25,70],['3',25,70],['4',25,70]);
    	$plantillas[1]['descripcion'] = '4 unidades, 20% 30% 20% 30% , se gana con 70pts.';
    	$plantillas[1]['unidades'] = array(['1',20,70],['2',30,70],['3',20,70],['4',30,70]);
    	$plantillas[2]['descripcion'] = '4 unidades, 20% 20% 30% 30% , se gana con 70pts.';
    	$plantillas[2]['unidades'] = array(['1',20,70],['2',20,70],['3',30,70],['4',30,70]);

    	foreach($plantillas as $plantilla)
    	{
    		$p = PlantillaUnidad::create([
	            'descripcion' => $plantilla['descripcion'],
	            'estado' => 'A',
	            'created_by' => 'admin',
	            'updated_by' => 'admin'
	        ]);
	        foreach($plantilla['unidades'] as $unidad)
	        {
	        	DetallePlantillaUnidad::create([
		            'plantilla_unidad_id' => $p->id,
		            'unidad' => $unidad[0],
		            'porcentaje' => $unidad[1],
		            'nota_ganar' => $unidad[2],
		            'estado' => 'A',
		            'created_by' => 'admin',
		            'updated_by' => 'admin'
		        ]);
	        }
    	}

    }
}
