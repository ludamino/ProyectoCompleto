<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdlActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_actividads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_actividad', 5000);
            $table->string('link_video', 5000)->nullable();
            $table->string('Documento', 5000)->nullable();
            $table->date('fecha_entrega');
            $table->unsignedBigInteger('clv_materia');
            $table->foreign('clv_materia')->references('id')->on('mdl_materias');
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
        Schema::dropIfExists('mdl_actividads');
    }
}
