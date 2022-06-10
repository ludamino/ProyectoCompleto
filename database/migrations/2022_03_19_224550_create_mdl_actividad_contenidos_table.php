<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdlActividadContenidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_actividad_contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta', 5000);
            $table->string('tipo_campo', 5000);
            $table->unsignedBigInteger('clv_actividad');
            $table->foreign('clv_actividad')->references('id')->on('mdl_actividads');
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
        Schema::dropIfExists('mdl_actividad_contenidos');
    }
}
