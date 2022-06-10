<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdlAsignarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdl_asignars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clv_actividad');
            $table->foreign('clv_actividad')->references('id')->on('mdl_actividads');
            $table->unsignedBigInteger('clv_usuario');
            $table->foreign('clv_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('mdl_asignars');
    }
}
