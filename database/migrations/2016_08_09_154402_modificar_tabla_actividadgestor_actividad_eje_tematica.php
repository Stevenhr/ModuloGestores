<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarTablaActividadgestorActividadEjeTematica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
       Schema::table('actividadgestor_actividad_eje_tematica', function (Blueprint $table) {
            $table->string('Otro');
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
        Schema::table('actividadgestor_actividad_eje_tematica', function (Blueprint $table) {
            $table->dropColum('Otro');
        });
    }
}
