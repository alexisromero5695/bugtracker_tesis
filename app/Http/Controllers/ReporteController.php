<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Estado;
use App\Models\Modulo;
use App\Models\Prioridad;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index($id_modulo)
    {
        $breadcrumb = Helper::breadcrumb($id_modulo, Modulo::where('vigente_modulo', 1)->get());


        $estados = Estado::where('vigente_estado', 1)->orderBy('orden_estado')->get();
        $prioridades = Prioridad::orderBy('orden_prioridad')->get();

        $data_chart_estado = [
            'labels' => array_column($estados->toArray(), 'nombre_estado'),
            'datasets' => [
                [
                    'label'=> 'Distribución de Incidencias',
                    'data' => [12, 19, 3, 5, 2, 5],
                    'backgroundColor' => array_column($estados->toArray(), 'color_estado'),
                    'borderColor' => array_column($estados->toArray(), 'color_estado'),
                    'borderWidth' => 1
                ]
            ]
        ];


 
        $data_chart_prioridad = [
            'labels' => array_column($prioridades->toArray(), 'nombre_prioridad'),
            'datasets' => [
                [
                    'label'=> 'Distribución de Incidencias',
                    'data' => [12, 19, 3, 5, 2, 5],
                    'backgroundColor' => array_column($prioridades->toArray(), 'color_prioridad'),
                    'borderColor' => array_column($prioridades->toArray(), 'color_prioridad'),
             
                ]
            ]
        ];
        return view('pages.reportes', compact('breadcrumb','data_chart_estado','data_chart_prioridad'));
    }
}
