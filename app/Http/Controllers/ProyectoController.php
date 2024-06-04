<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Modulo;
use App\Models\Proyecto;
use App\Models\Staff;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index($id_modulo)
    {
        $breadcrumb = Helper::breadcrumb($id_modulo, Modulo::where('vigente_modulo', 1)->get());
        return view('pages.proyectos', compact('breadcrumb'));
    }
    public function crear(Request $request)
    {
        if (!$request->id_proyecto) {
            Proyecto::create([
                'id_staff' => $request->staff,
                'id_avatar' => $request->avatar,
                'nombre_proyecto' => $request->nombre,
                'codigo_proyecto' => $request->codigo,
                'fecha_inicio_proyecto' => ($request->fecha_inicio) ? Carbon::parse($request->fecha_inicio)->format('Y-m-d') : null,
                'fecha_fin_proyecto' => ($request->fecha_fin) ? Carbon::parse($request->fecha_fin)->format('Y-m-d') : null,
                'descripcion_proyecto' => $request->description,
                'fecha_creacion_proyecto' => Carbon::now()
            ]);
        } else {
            Proyecto::where('id_proyecto', $request->id_proyecto)
                ->update([
                    'id_staff' => $request->staff,
                    'id_avatar' => $request->avatar,
                    'nombre_proyecto' => $request->nombre,
                    'codigo_proyecto' => $request->codigo,
                    'fecha_inicio_proyecto' => ($request->fecha_inicio) ? Carbon::parse($request->fecha_inicio)->format('Y-m-d') : null,
                    'fecha_fin_proyecto' => ($request->fecha_fin) ? Carbon::parse($request->fecha_fin)->format('Y-m-d') : null,
                    'descripcion_proyecto' => $request->description,
                ]);
        }

        return 'Exitoso';
    }
    public function tabla(Request $request)
    {
        $data = [];
        $proyectos =  Proyecto::leftjoin('staff', 'proyecto.id_staff', 'staff.id_staff')
            ->leftjoin('avatar', 'proyecto.id_avatar', 'avatar.id_avatar')
            ->where('vigente_proyecto',1)
            ->orderBy('fecha_creacion_proyecto')
            ->get();
        foreach ($proyectos as $key => $value) {
            $html_acciones = "<div class='dropdown'>
                            <a class='text-soft dropdown-toggle btn btn-icon btn-trigger'  data-toggle='dropdown' aria-expanded='false'  id='dropdownMenuButton' aria-haspopup='true'>
                                <em class='icon ni ni-more-h'></em> 
                            </a>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a data-id='" . $value->id_proyecto . "' href='javascript:void(0)' class='dropdown-item btn-md-editar-proyecto' href='#'><em class='icon ni ni-pen'></em> Editar</a>                                    
                                <a href='/incidencias/6/$value->codigo_proyecto' class='dropdown-item' href='#'><em class='icon ni ni-bugs'></em> Incidencias</a>
                                <a class='dropdown-item d-none' href='#'>Another action</a>
                                <a class='dropdown-item d-none' href='#'>Something else here</a>
                            </div>
                        </div>";
            $imagen_avatar = "/images/default/default-600.png";
            if ($value->imagen_avatar) {
                $imagen_avatar ="/files/avatar/{$value->imagen_avatar}";
            }
            array_push($data,    [
                'nombre' => "<div class='d-flex align-items-center'>
                                <div class='user-avatar sq mr-1'>
                                        <img  src='{$imagen_avatar}'>
                                </div>{$value->nombre_proyecto}
                            </div>",
                'codigo' => $value->codigo_proyecto,
                'staff' =>  "$value->nombre_staff $value->apellido_paterno_staff",
                'fecha_inicio' => ($value->fecha_inicio_proyecto) ? Carbon::parse($value->fecha_inicio_proyecto)->format('d-m-Y') : '',
                'accion' => $html_acciones,
            ]);
        }

        return DataTables::of($data)
            ->rawColumns(['nombre', 'accion'])
            ->make(true);
    }

    public function traer(Request $request)
    {
        $data_ = Proyecto::leftjoin('avatar', 'avatar.id_avatar', 'proyecto.id_avatar')->where('id_proyecto', $request->id_proyecto)->first();

        $nombre_responsable = null;
        $apellido_paterno_responsable = null;
        $apellido_materno_responsable = null;
        if ($data_['id_staff']) {
            $responsable = Staff::where('id_staff', $data_['id_staff'])->first();
            $nombre_responsable = $responsable['nombre_staff'];
            $apellido_paterno_responsable = $responsable['apellido_paterno_staff'];
            $apellido_materno_responsable = $responsable['apellido_materno_staff'];
        }

        $data = [
            'id_proyecto' => $data_['id_proyecto'],
            'nombre_proyecto' => $data_['nombre_proyecto'],
            'codigo_proyecto' => $data_['codigo_proyecto'],
            'fecha_inicio_proyecto' => $data_['fecha_inicio_proyecto'],
            'fecha_fin_proyecto' => $data_['fecha_fin_proyecto'],
            'descripcion_proyecto' => $data_['descripcion_proyecto'],
            'id_responsable' => $data_['id_staff'],
            'nombre_responsable' => $nombre_responsable,
            'apellido_paterno_responsable' => $apellido_paterno_responsable,
            'apellido_materno_responsable' => $apellido_materno_responsable,
            'id_avatar' => $data_['id_avatar'],
            'imagen_avatar' => $data_['imagen_avatar'],
        ];
        return response()->json($data);
    }
}
