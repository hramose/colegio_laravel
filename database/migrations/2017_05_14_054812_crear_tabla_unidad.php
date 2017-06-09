<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUnidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('curso_id')->unsigned();
            $table->string('unidad',1);
            $table->double('nota_ganar');
            $table->double('porcentaje')
                    ->comment('Porcentaje que representa la nota de la unidad para la nota acumulada del año.');
            $table->text('planificacion')->nullable();
            $table->string('archivo_planificacion')->nullable();
            $table->string('nombre_original_archivo')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('curso_id')->references('id')->on('curso');

            $table->unique(['curso_id', 'unidad']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad');
    }
}
