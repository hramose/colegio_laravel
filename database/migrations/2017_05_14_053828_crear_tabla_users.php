<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',100)->unique();
            $table->string('password');
            $table->integer('perfil_id')->unsigned();
            $table->tinyInteger('primera_vez');
            $table->string('estado',1);
            $table->string('observacion')->nullable();
            $table->integer('ciclo_id')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('perfil_id')->references('id')->on('perfil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
