<?php

namespace App;

use Idrd\Usuarios\Repo\Persona as MPersona;

class Persona extends MPersona
{
    //

     public function actividadGestor()
    {
        return $this->belongsToMany('App\ActividadGestor','persona_acopanante');
    }

    
}
