<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUnidadCurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidad_seccion_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->text('planificacion')->nullable();
            $table->string('archivo_planificacion')->nullable();
            $table->string('nombre_original_archivo')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('unidad_seccion_id')->references('id')->on('unidad_seccion');
            $table->foreign('curso_id')->references('id')->on('curso');

            $table->unique(['unidad_seccion_id', 'curso_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad_curso');
    }
}
