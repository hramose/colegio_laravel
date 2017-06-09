<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEstudianteSeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_seccion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo');
            $table->integer('estudiante_id')->unsigned();
            $table->integer('seccion_id')->unsigned();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('estudiante_id')->references('id')->on('persona');
            $table->foreign('seccion_id')->references('id')->on('seccion');
            $table->unique(['estudiante_id','seccion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiante_seccion');
    }
}
