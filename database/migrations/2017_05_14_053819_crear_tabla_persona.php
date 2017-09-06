<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('primer_nombre',100);
            $table->string('segundo_nombre',100)->nullable();
            $table->string('primer_apellido',100);
            $table->string('segundo_apellido',100)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('genero',1);
            $table->string('rol',1);
            $table->bigInteger('cui')->nullable();
            $table->string('encargado_1')->nullable();
            $table->string('parentesco_encargado_1',2)->nullable();
            $table->string('telefono_encargado_1',10)->nullable();
            $table->string('celular_encargado_1',10)->nullable();
            $table->string('encargado_2')->nullable();
            $table->string('parentesco_encargado_2',2)->nullable();
            $table->string('telefono_encargado_2',10)->nullable();
            $table->string('celular_encargado_2',10)->nullable();
            $table->string('direccion');
            $table->string('telefono',10)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('fotografia');
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
