<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaActividadEstudiante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actividad_id')->unsigned();
            $table->integer('estudiante_id')->unsigned();
            $table->integer('nota')->nullable();
            $table->string('archivo')->nullable();
            $table->longText('texto')->nullable();
            $table->datetime('fecha_entrega')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('actividad_id')->references('id')->on('actividad');
            $table->foreign('estudiante_id')->references('id')->on('persona');
            $table->unique(['actividad_id','estudiante_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad_estudiante');
    }
}
