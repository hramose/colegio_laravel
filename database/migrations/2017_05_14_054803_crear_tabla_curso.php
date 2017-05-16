<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seccion_id')->unsigned();
            $table->integer('materia_id')->unsigned();
            $table->integer('maestro_id')->unsigned();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('seccion_id')->references('id')->on('seccion');
            $table->foreign('materia_id')->references('id')->on('materia');
            $table->foreign('maestro_id')->references('id')->on('persona');

            $table->unique(['seccion_id', 'materia_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso');
    }
}
