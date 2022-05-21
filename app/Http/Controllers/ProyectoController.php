<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.proyectos');
    }
    public function crear(Request $request)
    {
        Proyecto::create([
            'id_staff' => $request->staff,
            'id_avatar' => $request->avatar,
            'nombre_proyecto' => $request->title,
            'codigo_proyecto' => $request->codigo,
            'fecha_inicio_proyecto' => Carbon::parse($request->fecha_inicio)->format('Y-m-d'),
            'fecha_fin_proyecto' => Carbon::parse($request->fecha_fin)->format('Y-m-d'),
            'descripcion_proyecto' => $request->description,
        ]);
        return 'Exitoso';
    }
    public function tabla(Request $request)
    {
        $data = [];
        $proyectos =  Proyecto::leftjoin('staff', 'proyecto.id_staff', 'staff.id_staff')
            ->join('avatar', 'proyecto.id_avatar', 'avatar.id_avatar')
            ->get();
        foreach ($proyectos as $key => $value) {
            array_push($data,    [
                'nombre' => "<div class='d-flex align-items-center'>
                                <div class='user-avatar sq mr-1'>
                                        <img  src='/files/avatar/{$value->imagen_avatar}'>
                                </div>{$value->nombre_proyecto}
                            </div>",
                'codigo' => $value->codigo_proyecto,
                'staff' =>  "$value->nombre_staff $value->apellido_paterno_staff",
                'fecha_inicio' => ($value->fecha_inicio_proyecto) ? Carbon::parse($value->fecha_inicio_proyecto)->format('d-m-Y') : '',
            ]);
        }

        return DataTables::of($data)
            ->rawColumns(['nombre'])
            ->make(true);
    }
}
