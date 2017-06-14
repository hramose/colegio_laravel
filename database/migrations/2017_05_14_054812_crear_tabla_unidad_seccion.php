<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUnidadSeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_seccion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seccion_id')->unsigned();
            $table->string('unidad',1);
            $table->double('nota_ganar');
            $table->double('porcentaje')
                    ->comment('Porcentaje que representa la nota de la unidad para la nota acumulada del año.');
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('seccion_id')->references('id')->on('seccion');

            $table->unique(['seccion_id', 'unidad']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad_seccion');
    }
}
