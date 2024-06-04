<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cliente;
use App\Models\Modulo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller
{
    public function index($id_modulo)
    {           
        $modulos = Modulo::where('vigente_modulo',1)->get(); 
        $breadcrumb =Helper::breadcrumb($id_modulo, $modulos);      
        return view('pages.clientes',compact('breadcrumb'));
    }

    public function tabla()
    {
        $clientes = Cliente::orderBy('orden_cliente')->where('vigente_cliente', 1)->get();

        $data = array();
        foreach ($clientes as $item) {
            array_push($data, [
                'id_cliente' => $item->id_cliente,
                'documento' => $item->documento_cliente,
                'nombre' => $item->nombre_cliente,
                "telefono" => $item->telefono_cliente,
                "correo" => $item->correo_cliente,
                'orden' => $item->orden_cliente
            ]);
        }
        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                $button = "<div class='dropdown'>
                                    <a class='text-soft dropdown-toggle btn btn-icon btn-trigger'  data-toggle='dropdown' aria-expanded='false'  id='dropdownMenuButton' aria-haspopup='true'>
                                        <em class='icon ni ni-more-h'></em> 
                                    </a>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a data-id='" . $data['id_cliente'] . "' href='javascript:void(0)' class='dropdown-item btn-md-editar-cliente' href='#'><em class='icon ni ni-pen'></em> Editar</a>                                    
                                        <a data-id='" . $data['id_cliente'] . "' href='javascript:void(0)' class='dropdown-item btn-md-eliminar-cliente' href='#'><em class='icon ni ni-trash'></em> Eliminar</a>                                     

                                    </div>
                                   
                                </div>";

                return $button;
            })
            ->rawColumns(['accion'])
            ->make(true);
    }

    public function crear(Request $request)
    {
        $errors = [];

        if ($request->id_cliente == 0) {
            if (Cliente::where('documento_cliente', $request->numero_documento)->exists()) {
                $errors['numero_documento'] = 'El número de documento "' . $request->numero_documento . '" ya está en uso.';
            }

            if (Cliente::where('correo_cliente', $request->correo)->exists()) {
                $errors['correo'] = 'El correo "' . $request->correo . '" ya está en uso.';
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $max_orden = Cliente::max('orden_cliente');

            Cliente::create([
                'nombre_cliente' => $request->nombre,
                'documento_cliente' => $request->numero_documento,
                'giro_cliente' => $request->giro,
                'telefono_cliente' => $request->telefono,
                'direccion_cliente' => $request->direccion,
                'correo_cliente' =>  $request->correo,
                'sitio_web_cliente' => $request->sitio_web,
                'fecha_creacion_cliente' => Carbon::now(),
                'orden_cliente' => $max_orden + 1,
                'vigente_cliente' => 1,
            ]);
        } else {

            if (Cliente::where('documento_cliente', $request->numero_documento)->where('id_cliente', '!=', $request->id_cliente)->exists()) {
                $errors['numero_documento'] = 'El número de documento "' . $request->numero_documento . '" ya está en uso.';
            }

            if (Cliente::where('correo_cliente', $request->correo)->where('id_cliente', '!=', $request->id_cliente)->exists()) {
                $errors['correo'] = 'El correo "' . $request->correo . '" ya está en uso.';
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            Cliente::where('id_cliente', $request->id_cliente)->update([
                'nombre_cliente' => $request->nombre,
                'documento_cliente' => $request->numero_documento,
                'giro_cliente' => $request->giro,
                'telefono_cliente' => $request->telefono,
                'direccion_cliente' => $request->direccion,
                'correo_cliente' =>  $request->correo,
                'sitio_web_cliente' => $request->sitio_web,
            ]);
        }
    }

    public function traer(Request $request)
    {
        $cliente = Cliente::where('id_cliente', $request->id_cliente)->first();
        return response()->json($cliente);
    }

    public function eliminar(Request $request)
    {
        //validar dependencia
        $id_usuario = Cliente::where('id_cliente', $request->id_cliente)->delete();
    }
}
