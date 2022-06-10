<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdlRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clv_actividad');
            $table->foreign('clv_actividad')->references('id')->on('mdl_actividads');
            $table->unsignedBigInteger('clv_contenido');
            $table->foreign('clv_contenido')->references('id')->on('mdl_actividad_contenidos');
            $table->unsignedBigInteger('clv_alumno');
            $table->foreign('clv_alumno')->references('id')->on('users');
            $table->string('respuesta', 5000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mdl_respuestas');
    }
}
