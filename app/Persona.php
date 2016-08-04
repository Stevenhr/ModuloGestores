<?php

namespace App;

use Idrd\Usuarios\Repo\Persona as MPersona;

class Persona extends MPersona
{
    //

     public function actividadGestor()
    {

        //return $this->hasMany('App\ActividadGestor', 'Id_Persona', 'Id_Persona');
        return $this->belongsToMany('App\ActividadGestor','actividadgestor_persona','actividad_gestor_id','persona_id');
    }


    public function localidades()
    {
       return $this->belongsToMany('App\Localidad',config('database.connections.mysql.database').'.persona_localidad','id_persona','id_localidad');
    }
}
