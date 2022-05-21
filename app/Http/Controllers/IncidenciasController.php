<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IncidenciasController extends Controller
{
    public function index($id_proyecto = null)
    {
        $proyecto = [];
        if ($id_proyecto) {
            $proyecto = Proyecto::leftjoin('staff', 'proyecto.id_staff', 'staff.id_staff')
                ->join('avatar', 'proyecto.id_avatar', 'avatar.id_avatar')
                ->where('proyecto.id_proyecto', $id_proyecto)
                ->first();
            if (!$proyecto) {
                abort(404);
            }
        }
        return view('pages.incidencias', compact('proyecto', 'id_proyecto'));
    }
    public function tabla(Request $request)
    {
        $data = [];
        $sql = "select 
                incidencia.id_incidencia,
                incidencia.numero_incidencia,
                tipo_incidencia.nombre_tipo_incidencia as tipo,
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
                estado_incidencia.nombre_estado_incidencia as estado,
                estado_incidencia.color_estado_incidencia as color_estado,
                resolucion.nombre_resolucion as resolucion,
                incidencia.fecha_creacion_incidencia,
                incidencia.fecha_actualizacion_incidencia,
                incidencia.fecha_vencimiento_incidencia
                from incidencia 
                inner join proyecto on proyecto.id_proyecto = incidencia.id_proyecto 
                left join staff as informante on informante.id_staff = incidencia.id_informante 
                left join color as color_informante on color_informante.id_color = informante.id_color 

                left join staff as responsable on responsable.id_staff = incidencia.id_responsable 
                left join color as color_responsable on color_responsable.id_color = responsable.id_color
                inner join estado_incidencia on estado_incidencia.id_estado_incidencia = incidencia.id_estado_incidencia 
                inner join prioridad on prioridad.id_prioridad = incidencia.id_prioridad 
                inner join tipo_incidencia on tipo_incidencia.id_tipo_incidencia = incidencia.id_tipo_incidencia 
                left join resolucion on resolucion.id_resolucion = incidencia.id_resolucion";
        if ($request->id_proyecto) {
            $sql .=  " where proyecto.id_proyecto = $request->id_proyecto";
        }

        $issues =   DB::select(DB::raw($sql));

        foreach ($issues as $key => $value) {


            if ($value->id_responsable) {
                $handlerAbrev = strtoupper(substr($value->nombre_responsable, 0, 1) . '' . substr($value->apellido_paterno_responsable, 0, 1));
                $responsable = "<div class='user-card text-nowrap'>
                            <div class='user-avatar xs bg-$value->color_responsable'>
                                <span>$handlerAbrev</span>
                            </div>
                            <div class=''>
                                <span class='tb-lead ml-2'>$value->nombre_responsable $value->apellido_paterno_responsable</span>
                            </div>
                        </div>";
            } else {
                $responsable = "<div class='user-card text-nowrap'>
                                <img  style='max-width:17%' src='/images/default/sin-asignar.svg'>
                                <div class=''>
                                    <span class='tb-lead ml-2'>Sin asignar</span>
                                </div>
                            </div>";
            }

  
            if ($value->id_informante) {
                $reporterrAbrev = strtoupper(substr($value->nombre_informante, 0, 1) . '' . substr($value->apellido_paterno_informante, 0, 1));
                $informante = "<div class='user-card text-nowrap'>
                                <div class='user-avatar xs bg-$value->color_informante'>
                                    <span>$reporterrAbrev</span>
                                </div>
                                <div class=''>
                                    <span class='tb-lead ml-2'>$value->nombre_informante $value->apellido_paterno_informante</span>
                                </div>
                            </div>";
            }else{
                $informante = "<div class='user-card text-nowrap'>
                                <img  style='max-width:17%' src='/images/default/sin-asignar.svg'>
                                <div class=''>
                                    <span class='tb-lead ml-2'>Sin asignar</span>
                                </div>
                            </div>";
            }

            

            array_push($data,    [
                'tipo' =>  $value->tipo,
                'codigo' => "<p class='text-nowrap'> $value->codigo_proyecto-$value->numero_incidencia</p>",
                'nombre' => "<p class='text-nowrap'> $value->nombre_incidencia</p>",
                'responsable' =>  $responsable,
                'informante' =>  $informante,
                'prioridad' => "<img src='/files/priority/$value->imagen_prioridad'>",
                'estado' => "<span style='border-radius: 14px; background: $value->color_estado; color: #fff;padding: 3px 8px;' class='text-nowrap'>$value->estado</span>",
                'resolucion' => $value->resolucion,
                'fecha_creacion' => ($value->fecha_creacion_incidencia) ?  "<p class='text-nowrap'> " . Carbon::parse($value->fecha_creacion_incidencia)->format('d-m-Y g:i A') . "</p>" : '',
                'fecha_actualizacion' => ($value->fecha_actualizacion_incidencia) ?  "<p class='text-nowrap'> " . Carbon::parse($value->fecha_actualizacion_incidencia)->format('d-m-Y g:i A') . "</p>" : '',
                'fecha_vencimiento' => ($value->fecha_vencimiento_incidencia) ?   "<p class='text-nowrap'>" .  Carbon::parse($value->fecha_vencimiento_incidencia)->format('d-m-Y') . " </p>" : '',
            ]);
        }

        return DataTables::of($data)
            ->rawColumns([
                'codigo',
                'nombre',
                'responsable',
                'informante',
                'prioridad',
                'estado',
                'fecha_creacion',
                'fecha_actualizacion',
                'fecha_vencimiento'
            ])
            ->make(true);
    }
}
