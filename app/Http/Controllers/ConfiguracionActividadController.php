<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ConfiguracionActividadController extends Controller
{
    //
	public function buscarTematicas(Request $request, $id_eje)
	{
		$eje_model = app()->make('App\Eje');
		$eje = $eje_model->find($id_eje);

		return response()->json($eje->tematica);
	}

	//
	public function buscarActividades(Request $request, $id_tematica)
	{
		$tematica_model_ = app()->make('App\Tematica');
		$actividad = $tematica_model_->find($id_tematica);

		return response()->json($actividad->actividad);
	}
}
