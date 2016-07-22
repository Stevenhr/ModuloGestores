<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ActividadGestor extends Model
{
      //

	use SoftDeletes;
	
  protected $table = 'actividad_gestor';
	protected $primaryKey = 'Id_Actividad_Gestor';
	protected $fillable = ['Id_Persona','Id_Responsable','Fecha_Ejecucion','Hora_Incial','Hora_Final','Localidad','Parque','Caracteristica_Lugar','Instit_Grupo_Comun','Caracteristica_Poblacion','Numero_Asistente','Hora_Implementacion','Nombre_Contacto','Rool_Comunidad','Telefono','Fecha_Registro','Estado','Estado_Ejecucion','Fecha_Registro_Ejecución'];
	protected $connection = ''; 


  	public function __construct()
  	{
  		$this->connection = config('connections.mysql');
  	}

	  public function datosActividad()
    {
        return $this->hasMany('App\DatosActividad','Id_Actividad');
    }

     public function actividadgestorActividadEjeTematica()
    {
        return $this->belongsToMany('App\ActividadGestor','actividadgestor_actividad_eje_tematica','actividad_gestor_id','eje_id','tematica_id','actividad_id');
    }

    public function localidad() {
        return $this->belongsTo('App\Localidad', 'Localidad'); 
    }

    public function parque() {
        return $this->belongsTo('App\Parque', 'Parque'); 
    }

     public function persona() {
        return $this->belongsTo('App\Persona', 'Id_Responsable'); 
    }

    public function personaProgramador() {
        return $this->belongsTo('App\Persona', 'Id_Persona'); 
    }

    public function ejecucion()
    {
        return $this->hasMany('App\Ejecucion','Id_Actividad_Gestor');
    }

    public function novedad()
    {
        return $this->hasMany('App\Novedad','Id_Actividad_Gestor');
    }

    public function calificaciomServicio()
    {
        return $this->hasMany('App\Calificacion_servicio','Id_Actividad_Gestor');
    }

     
}
