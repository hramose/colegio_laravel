<?php

$factory->define(\App\App\Entities\Persona::class, function (Faker\Generator $faker) {
	$faker = Faker\Factory::create('es_ES');
	
	return [
	    'primer_apellido' => $faker->lastName,
	    'segundo_apellido' => $faker->lastName,
	    'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-25 years', $timezone = date_default_timezone_get()),
	    
	    'cui' => abs(rand(1000000000000, 9000000000000)),
	    'direccion' => $faker->address,
	    'telefono' => $faker->randomNumber($nbDigits = 8, $strict = true),
	    'celular' => $faker->randomNumber($nbDigits = 8, $strict = true),
	    
	    'estado' => 'A',
	    'created_by' => 'admin',
	    'updated_by' => 'admin'
  	];
});

$factory->state(\App\App\Entities\Persona::class, 'maestro', function (\Faker\Generator $faker) {
	$faker = Faker\Factory::create('es_ES');
	$gender = $faker->randomElement(['male', 'female']);
	return [
		'primer_nombre' => $faker->firstName($gender),
	    'segundo_nombre' => $faker->firstName($gender),
    	'rol' => 'M',
    	'fotografia' => 'personas/'.$gender.'.png',
    	'genero' => strtoupper(substr($gender, 0, 1)),
  	];
});

$factory->state(\App\App\Entities\Persona::class, 'estudiante', function (\Faker\Generator $faker) {
	$faker = Faker\Factory::create('es_ES');
	$gender = $faker->randomElement(['male', 'female']);
	if($gender == 'male') $fotografia = 'boy'; else $fotografia = 'girl';
	return [
		'primer_nombre' => $faker->firstName($gender),
	    'segundo_nombre' => $faker->firstName($gender),
    	'rol' => 'E',
    	'fotografia' => 'personas/'.$fotografia.'.png',
    	'genero' => strtoupper(substr($gender, 0, 1)),
    	'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-17 years', $endDate = '-10 years', $timezone = date_default_timezone_get()),
  	];
});
