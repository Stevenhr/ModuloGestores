<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    //
    protected $table = 'tematica';
	protected $primaryKey = 'Id_Tematica';
	protected $fillable = ['Nombre_Tematica'];
	protected $connection = ''; 
	public $timestamps = false;

	public function __construct()
	{
		$this->connection = config('connections.mysql');
	}
}
