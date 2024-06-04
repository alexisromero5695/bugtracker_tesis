<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Incidencia;
use App\Models\Prioridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $estados = Estado::where('vigente_estado', 1)->orderBy('orden_estado')->get();
        $prioridades = Prioridad::orderBy('orden_prioridad')->get();
        $sql = "select 
        incidencia.id_incidencia,
        incidencia.numero_incidencia,
        tipo.nombre_tipo as tipo,
        proyecto.codigo_proyecto,
        incidencia.nombre_incidencia,
        incidencia.id_informante,
        incidencia.id_responsable,
        responsable.nombre_staff as nombre_responsable, 
        responsable.apellido_paterno_staff as apellido_paterno_responsable,
        color_responsable.nombre_color as color_responsable,       
        informante.nombre_staff as nombre_informante, 
        informante.apellido_paterno_staff as apellido_paterno_informante,
        color_informante.nombre_color as color_informante,        
        prioridad.nombre_prioridad as prioridad,
        prioridad.imagen_prioridad,
        estado.nombre_estado as estado,
        estado.color_estado,
        estado.color_texto_estado,
        resolucion.nombre_resolucion as resolucion,
        incidencia.fecha_creacion_incidencia,
        incidencia.fecha_actualizacion_incidencia,
        incidencia.fecha_vencimiento_incidencia,
        color_prioridad,
        color_texto_prioridad
        from incidencia 
        inner join proyecto on proyecto.id_proyecto = incidencia.id_proyecto 
        left join staff as informante on informante.id_staff = incidencia.id_informante 
        left join color as color_informante on color_informante.id_color = informante.id_color 

        left join staff as responsable on responsable.id_staff = incidencia.id_responsable 
        left join color as color_responsable on color_responsable.id_color = responsable.id_color
        inner join estado on estado.id_estado = incidencia.id_estado 
        inner join prioridad on prioridad.id_prioridad = incidencia.id_prioridad 
        inner join tipo on tipo.id_tipo = incidencia.id_tipo 
        left join resolucion on resolucion.id_resolucion = incidencia.id_resolucion
        order by orden_incidencia asc        
        limit 10";

        $incidencias = DB::select(DB::raw($sql));

        $data_chart_estado = [
            'labels' => array_column($estados->toArray(), 'nombre_estado'),
            'datasets' => [
                [
                    'data' => [13, 13, 3, 7, 8, 2],
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
                    'data' => [7, 7, 15, 12, 1, 2],
                    'backgroundColor' => array_column($prioridades->toArray(), 'color_prioridad'),
                    'borderColor' => array_column($prioridades->toArray(), 'color_prioridad'),
                    'borderWidth' => 1
                ]
            ]
        ];


        return view('home', compact('estados', 'incidencias', 'data_chart_estado', 'data_chart_prioridad'));
    }
}
