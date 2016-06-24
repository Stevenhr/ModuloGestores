<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersonaAcompanate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('persona_acopanante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Id_Persona')->unsigned();
            $table->foreign('Id_Persona')->references('Id_Persona')->on('Persona');
            $table->integer('Id_Actividad_Gestor')->unsigned();
            $table->foreign('Id_Actividad_Gestor')->references('Id_Actividad_Gestor')->on('actividad_gestor');
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
        //
        Schema::drop('persona_acopanante');
    }
}
