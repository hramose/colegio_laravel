<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidad_curso_id')->unsigned();
            $table->integer('tipo_actividad_id')->unsigned();
            $table->string('titulo');
            $table->text('descripcion');
            $table->double('porcentaje');
            $table->string('archivo')->nullable();
            $table->string('nombre_original_archivo')->nullable();
            $table->tinyInteger('aplica_fecha');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->tinyInteger('entrega_via_web');
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('unidad_curso_id')->references('id')->on('unidad_curso');
            $table->foreign('tipo_actividad_id')->references('id')->on('tipo_actividad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad');
    }
}
