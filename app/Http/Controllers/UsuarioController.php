<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\PerfilModulo;
use App\Models\PerfilModuloUsuario;
use App\Models\Staff;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsuarioController extends Controller
{
    public function index($id_modulo)
    {
        $perfiles = Perfil::where('vigente_perfil', 1)->get();
        $breadcrumb =Helper::breadcrumb($id_modulo, Modulo::where('vigente_modulo',1)->get());      
        return view('pages.usuarios', compact('perfiles','breadcrumb'));
    }

    public function tabla()
    {
        $staffs = Staff::join('usuario', 'usuario.id_staff', 'staff.id_staff')
            ->join('perfil', 'usuario.id_perfil', 'perfil.id_perfil')
            ->orderBy('orden_staff')
            ->get();

        $data = array();
        foreach ($staffs as $item) {
            array_push($data, [
                'id_staff' => $item->id_staff,
                'documento' => $item->documento_staff,
                'nombre' => $item->nombre_staff,
                "apellidos" => $item->apellido_paterno_staff . " " . $item->apellido_materno_staff,
                "telefono" => $item->telefono_staff,
                "correo" => $item->correo_usuario,
                "perfil" => $item->nombre_perfil,
                'orden' => $item->orden_staff
            ]);
        }
        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                $button = "<div class='dropdown'>
                                    <a class='text-soft dropdown-toggle btn btn-icon btn-trigger'  data-toggle='dropdown' aria-expanded='false'  id='dropdownMenuButton' aria-haspopup='true'>
                                        <em class='icon ni ni-more-h'></em> 
                                    </a>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a data-id='" . $data['id_staff'] . "' href='javascript:void(0)' class='dropdown-item btn-md-editar-usuario' href='#'><em class='icon ni ni-pen'></em> Editar</a>                                    
                                        <a data-id='" . $data['id_staff'] . "' href='javascript:void(0)' class='dropdown-item btn-md-eliminar-usuario' href='#'><em class='icon ni ni-trash'></em> Eliminar</a>                                     

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

        if ($request->id_staff == 0) {
            if (Staff::where('documento_staff', $request->numero_documento)->exists()) {
                $errors['numero_documento'] = 'El número de documento "' . $request->numero_documento . '" ya está en uso.';
            }

            if (Usuario::where('correo_usuario', $request->correo)->exists()) {
                $errors['correo'] = 'El correo "' . $request->correo . '" ya está en uso.';
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $max_orden = Staff::max('orden_staff');
            $orden_staff = $max_orden + 1;

            $staff = Staff::create([
                'nombre_staff' => $request->nombre,
                'apellido_paterno_staff' =>  $request->apellido_paterno,
                'apellido_materno_staff' => $request->apellido_materno,
                'documento_staff' => $request->numero_documento,
                'direccion_staff' => $request->apellido_materno,
                'telefono_staff' => $request->telefono,
                'vigente_staff' => 1,
                'orden_staff' => $orden_staff
            ]);
            $Usuario = Usuario::create([
                'id_staff' => $staff['id_staff'],
                'id_perfil' => $request->perfil,
                'correo_usuario' =>  $request->correo,
                'contrasenia_usuario' => Hash::make($request->contrasenia),
                'vigente_usuario' => 1
            ]);

            $PerfilModulo = PerfilModulo::where('id_perfil', $request->perfil)
                ->join('modulo', 'modulo.id_modulo', 'perfil_modulo.id_modulo')
                ->get();
            foreach ($PerfilModulo as $key => $value) {
                $accioncrear_perfil_modulo_usuario = 0;
                $accioneditar_perfil_modulo_usuario = 0;
                $accioneliminar_perfil_modulo_usuario = 0;
                $accionaprobacion_perfil_modulo_usuario = 0;
                if ($value->tipoaccion_modulo) {
                    $acciones = explode("", $value->tipoaccion_modulo);
                    if (isset($acciones[0])) {
                        $accioncrear_perfil_modulo_usuario = $acciones[0];
                    }
                    if (isset($acciones[1])) {
                        $accioneditar_perfil_modulo_usuario = $acciones[1];
                    }
                    if (isset($acciones[2])) {
                        $accioneliminar_perfil_modulo_usuario = $acciones[2];
                    }
                    if (isset($acciones[3])) {
                        $accionaprobacion_perfil_modulo_usuario = $acciones[3];
                    }
                }
                PerfilModuloUsuario::create([
                    'id_usuario' => $Usuario['id_usuario'],
                    'id_perfil_modulo' => $value->id_perfil_modulo,
                    'accioncrear_perfil_modulo_usuario' => $accioncrear_perfil_modulo_usuario,
                    'accioneditar_perfil_modulo_usuario' => $accioneditar_perfil_modulo_usuario,
                    'accioneliminar_perfil_modulo_usuario' => $accioneliminar_perfil_modulo_usuario,
                    'accionaprobacion_perfil_modulo_usuario' => $accionaprobacion_perfil_modulo_usuario,
                ]);
            }
        } else {
            $Usuario =   Usuario::where('id_staff', $request->id_staff)->first();
            $id_perfil_historico = $Usuario['id_perfil'];
            if (Staff::where('documento_staff', $request->numero_documento)->where('id_staff', '!=', $request->id_staff)->exists()) {
                $errors['numero_documento'] = 'El número de documento "' . $request->numero_documento . '" ya está en uso.';
            }

            if (Usuario::where('correo_usuario', $request->correo)->where('id_staff', '!=', $request->id_staff)->exists()) {
                $errors['correo'] = 'El correo "' . $request->correo . '" ya está en uso.';
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $staff = Staff::where('id_staff', $request->id_staff)->update([
                'nombre_staff' => $request->nombre,
                'apellido_paterno_staff' =>  $request->apellido_paterno,
                'apellido_materno_staff' => $request->apellido_materno,
                'documento_staff' => $request->numero_documento,
                'direccion_staff' => $request->apellido_materno,
                'telefono_staff' => $request->telefono,
            ]);

            Usuario::where('id_staff', $request->id_staff)->update([
                'id_perfil' => $request->perfil,
                'correo_usuario' =>  $request->correo,
            ]);

            if ($id_perfil_historico != $request->perfil) {
                $perfil_modulo_usuario = PerfilModulo::join('perfil_modulo_usuario', 'perfil_modulo_usuario.id_perfil_modulo', 'perfil_modulo.id_perfil_modulo')
                    ->where('perfil_modulo.id_perfil', $request->id_perfil)
                    ->where('perfil_modulo_usuario.id_usuario', $Usuario['id_usuario'])
                    ->pluck('perfil_modulo_usuario.id_perfil_modulo_usuario');

                PerfilModuloUsuario::whereIn('id_perfil_modulo_usuario', $perfil_modulo_usuario)->delete();

                $PerfilModulo = PerfilModulo::where('id_perfil', $request->perfil)
                    ->join('modulo', 'modulo.id_modulo', 'perfil_modulo.id_modulo')
                    ->get();
                foreach ($PerfilModulo as $key => $value) {
                    $accioncrear_perfil_modulo_usuario = 0;
                    $accioneditar_perfil_modulo_usuario = 0;
                    $accioneliminar_perfil_modulo_usuario = 0;
                    $accionaprobacion_perfil_modulo_usuario = 0;
                    if ($value->tipoaccion_modulo) {
                        $acciones = explode("", $value->tipoaccion_modulo);
                        if (isset($acciones[0])) {
                            $accioncrear_perfil_modulo_usuario = $acciones[0];
                        }
                        if (isset($acciones[1])) {
                            $accioneditar_perfil_modulo_usuario = $acciones[1];
                        }
                        if (isset($acciones[2])) {
                            $accioneliminar_perfil_modulo_usuario = $acciones[2];
                        }
                        if (isset($acciones[3])) {
                            $accionaprobacion_perfil_modulo_usuario = $acciones[3];
                        }
                    }
                    PerfilModuloUsuario::create([
                        'id_usuario' => $Usuario['id_usuario'],
                        'id_perfil_modulo' => $value->id_perfil_modulo,
                        'accioncrear_perfil_modulo_usuario' => $accioncrear_perfil_modulo_usuario,
                        'accioneditar_perfil_modulo_usuario' => $accioneditar_perfil_modulo_usuario,
                        'accioneliminar_perfil_modulo_usuario' => $accioneliminar_perfil_modulo_usuario,
                        'accionaprobacion_perfil_modulo_usuario' => $accionaprobacion_perfil_modulo_usuario,
                    ]);
                }
            }
        }
    }

    public function traer(Request $request)
    {
        $staff = Staff::join('usuario', 'usuario.id_staff', 'staff.id_staff')
            ->join('perfil', 'perfil.id_perfil', 'usuario.id_perfil')
            ->where('staff.id_staff', $request->id_staff)
            ->first();

        return response()->json([
            'nombre_staff' => $staff['nombre_staff'],
            'apellido_paterno_staff' => $staff['apellido_paterno_staff'],
            'apellido_materno_staff' => $staff['apellido_materno_staff'],
            'documento_staff' => $staff['documento_staff'],
            'direccion_staff' => $staff['direccion_staff'],
            'telefono_staff' => $staff['telefono_staff'],
            'id_perfil' => $staff['id_perfil'],
            'correo_usuario' => $staff['correo_usuario'],
        ]);
    }

    public function eliminar(Request $request)
    {
        $id_usuario = Usuario::where('id_staff', $request->id_staff)->value('id_usuario');
        Staff::where('staff.id_staff', $request->id_staff)->delete();
        PerfilModuloUsuario::where('id_usuario', $id_usuario)->delete();
        Usuario::where('id_staff', $request->id_staff)->delete();
    }
}
