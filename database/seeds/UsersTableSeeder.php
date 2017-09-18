<?php

use Illuminate\Database\Seeder;
use App\App\Entities\User;
use App\App\Entities\Persona;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdministrador = Persona::create([
            'primer_nombre' => 'Super',
            'primer_apellido' => 'Administrador',
            'fecha_nacimiento' => '2000-01-01',
            'genero' => 'M',
            'rol' => 'A',
            'cui' => '0000000000000',
            'direccion' => 'Guatemala',
            'telefono' => '00000000',
            'celular' => '00000000',
            'fotografia' => 'personas/male.png',
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $administrador = Persona::create([
            'primer_nombre' => 'Administrador',
            'primer_apellido' => 'Administrador',
            'fecha_nacimiento' => '2000-01-01',
            'genero' => 'M',
            'rol' => 'A',
            'cui' => '0000000000000',
            'direccion' => 'Guatemala',
            'telefono' => '00000000',
            'celular' => '00000000',
            'fotografia' => 'personas/male.png',
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $maestro = Persona::create([
            'primer_nombre' => 'Profesor',
            'primer_apellido' => 'Jirafales',
            'fecha_nacimiento' => '2000-01-01',
            'genero' => 'M',
            'rol' => 'M',
            'cui' => '0000000000000',
            'direccion' => 'Guatemala',
            'telefono' => '00000000',
            'celular' => '00000000',
            'fotografia' => 'personas/male.png',
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $estudiante = Persona::create([
            'primer_nombre' => 'Chavo',
            'primer_apellido' => 'Del 8',
            'fecha_nacimiento' => '2000-01-01',
            'genero' => 'M',
            'rol' => 'E',
            'cui' => '0000000000000',
            'direccion' => 'Guatemala',
            'telefono' => '00000000',
            'celular' => '00000000',
            'fotografia' => 'personas/male.png',
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $user = User::create([
        	'username' => 'superadmin',
        	'password' => 'superadmin',
        	'perfil_id' => 1,
            'persona_id' => $superAdministrador->id,
        	'primera_vez' => 1,
        	'estado' => 'A',
        	'created_by' => 'superadmin',
        	'updated_by' => 'superadmin'
        ]);

        $user = User::create([
            'username' => 'admin',
            'password' => 'admin',
            'perfil_id' => 2,
            'persona_id' => $administrador->id,
            'primera_vez' => 1,
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $userMaestro = User::create([
            'username' => 'jirafales',
            'password' => 'jirafales',
            'perfil_id' => 3,
            'persona_id' => $maestro->id,
            'primera_vez' => 1,
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);

        $userEstudiante = User::create([
            'username' => 'chavo8',
            'password' => 'chavo8',
            'perfil_id' => 4,
            'persona_id' => $estudiante->id,
            'primera_vez' => 1,
            'estado' => 'A',
            'created_by' => 'superadmin',
            'updated_by' => 'superadmin'
        ]);
    }
}
