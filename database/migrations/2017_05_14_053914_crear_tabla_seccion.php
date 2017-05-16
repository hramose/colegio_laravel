<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ciclo_id')->unsigned();
            $table->integer('grado_id')->unsigned();
            $table->string('seccion',1);
            $table->integer('maestro_id')->unsigned();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('ciclo_id')->references('id')->on('ciclo');
            $table->foreign('grado_id')->references('id')->on('grado');
            $table->foreign('maestro_id')->references('id')->on('persona');

            $table->unique(['ciclo_id', 'grado_id','seccion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seccion');
    }
}
