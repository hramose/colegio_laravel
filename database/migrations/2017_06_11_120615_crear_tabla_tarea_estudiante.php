<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTareaEstudiante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea_estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tarea_id')->unsigned();
            $table->integer('estudiante_id')->unsigned();
            $table->integer('nota')->nullable();
            $table->string('archivo')->nullable();
            $table->longText('texto')->nullable();
            $table->datetime('fecha_entrega')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('tarea_id')->references('id')->on('tarea');
            $table->foreign('estudiante_id')->references('id')->on('persona');
            $table->unique(['tarea_id','estudiante_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarea_estudiante');
    }
}
