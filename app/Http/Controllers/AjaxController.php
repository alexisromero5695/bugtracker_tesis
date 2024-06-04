<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Staff;
use App\Models\Cliente;
use App\Models\TipoIncidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    function listarProyectos(Request $request)
    {
        $data =  Proyecto::join('avatar', 'avatar.id_avatar', 'proyecto.id_avatar')
            ->where('vigente_proyecto', 1)
            ->get();
        return response()->json($data);
    }
    function listarTipoIncidencia(Request $request)
    {
        $data =  TipoIncidencia::get();
        return response()->json($data);
    }
    public function listarStaff()
    {
        $data = Staff::where('vigente_staff', 1)->get();
        return response()->json($data);
    }


    public function listarStaffAutocomplete(Request $request)
    {
        $usuarios = Staff::where('vigente_staff', 1);
        $usuarios = $usuarios->where(function ($query) use ($request) {
            $query->where(DB::raw("CONCAT(nombre_staff)"), "like", "%$request->search%");
            $query->where(DB::raw("CONCAT(apellido_paterno_staff)"), "like", "%$request->search%");
            $query->where(DB::raw("CONCAT(apellido_materno_staff)"), "like", "%$request->search%");
            $query->orWhere(DB::raw("CONCAT(nombre_staff,' ',apellido_paterno_staff)"), "like", "%$request->search%");
            $query->orWhere(DB::raw("CONCAT(nombre_staff,' ',apellido_paterno_staff,' ',apellido_materno_staff)"), "like", "%$request->search%");
        });
        $usuarios = $usuarios->get();
        return response()->json($usuarios);
    }

    public function listarClienteAutocomplete(Request $request)
    {
        $clientes = Cliente::where('vigente_cliente', 1);
        $clientes = $clientes->where(function ($query) use ($request) {
            $query->where(DB::raw("CONCAT(nombre_cliente)"), "like", "%$request->search%");
        });
        $clientes = $clientes->get();
        return response()->json($clientes);
    }

    
}
