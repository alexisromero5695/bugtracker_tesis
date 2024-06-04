<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Perfil;
use App\Models\PerfilModulo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Helper as Helper;
use App\Models\PerfilModuloUsuario;
use Carbon\Carbon;

class PerfilesController extends Controller
{
    public function index($id_modulo)
    {
        $modulos = json_decode(Helper::CargarMenu());
        $modulos = $modulos->menu;
        $breadcrumb =Helper::breadcrumb($id_modulo, Modulo::where('vigente_modulo',1)->get());      
        return view('pages.perfiles', compact('modulos','breadcrumb'));
    }

    public static function ObtenerPadre($id_submodulo)
    {
        $modulo =  Modulo::select('idpadre_modulo', 'id_modulo')->where('id_modulo', $id_submodulo)->first();
        $modulos = "";

        $modulos .= $modulo['id_modulo'];
        if ($modulo['idpadre_modulo']  == 0) {
        } else {
            $modulos  =  self::ObtenerPadre($modulo['idpadre_modulo']);
        }
        return $modulos;
    }

    public function tabla()
    {
        $perfiles =  Perfil::select('*')
            ->where('perfil.vigente_perfil', 1)
            ->get();

        $data = array();
        foreach ($perfiles as $item) {

            $submodulos = PerfilModulo::select('id_modulo')
                ->where('id_perfil', $item->id_perfil)
                ->get();

            $modulosPadre = [];
            foreach ($submodulos as $sm) {
                array_push($modulosPadre, self::ObtenerPadre($sm->id_modulo));
            }

            $array_palabras =   Modulo::whereIn('id_modulo', $modulosPadre)->pluck('nombre_modulo');
            $cadena_resultante = "";
            $contador = 0;

            foreach ($array_palabras as $key => $palabra) {
                $cadena_resultante .= $palabra . ($key != count($array_palabras) - 1 ? ", " : ". ");
                $contador++;
                if ($contador % 3 == 0) {
                    $cadena_resultante .= "<br>";
                }
            }
            array_push($data, [
                'id_perfil' => $item->id_perfil,
                'nombre' => $item->nombre_perfil,
                "modulos" => $cadena_resultante,
            ]);
        }

        return DataTables::of($data)
            ->addColumn('accion', function ($data) {
                $button = "<div class='dropdown'>
                                    <a class='text-soft dropdown-toggle btn btn-icon btn-trigger'  data-toggle='dropdown' aria-expanded='false'  id='dropdownMenuButton' aria-haspopup='true'>
                                        <em class='icon ni ni-more-h'></em> 
                                    </a>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a data-id='" . $data['id_perfil'] . "' href='javascript:void(0)' class='dropdown-item btn-md-editar-perfil' href='#'><em class='icon ni ni-pen'></em> Editar</a>                                    
                                    </div>
                                </div>";

                return $button;
            })
            ->rawColumns(['modulos', 'accion'])
            ->make(true);
    }

    public function crear(Request $request)
    {

        if ($request->id_perfil == 0) {
            $perfil = Perfil::create([
                'nombre_perfil' => $request->nombre,
                'fecha_creacion_perfil' => Carbon::now(),
                'vigente_perfil' => 1,
            ]);

            if ($request->modulo) {
                foreach ($request->modulo as $key => $id_modulo) {
                    PerfilModulo::create([
                        'id_perfil' => $perfil['id_perfil'],
                        'id_modulo' => $id_modulo
                    ]);
                }
            }
        } else {
            Perfil::where('id_perfil', $request->id_perfil)->update([
                'nombre_perfil' => $request->nombre,
            ]);

            $usuarios = PerfilModulo::join('perfil_modulo_usuario', 'perfil_modulo_usuario.id_perfil_modulo', 'perfil_modulo.id_perfil_modulo')
                ->where('perfil_modulo.id_perfil', $request->id_perfil)
                ->distinct()
                ->pluck('perfil_modulo_usuario.id_usuario');

            $PerfilModulo =  PerfilModulo::where('id_perfil', $request->id_perfil)->get();

            foreach ($PerfilModulo as $key => $perfil_modulo) {
                if ((isset($request->modulo) && !in_array($perfil_modulo->id_modulo, $request->modulo)) || !isset($request->modulo)) {

                    $PerfilModulo =  PerfilModulo::where('id_perfil_modulo', $perfil_modulo->id_perfil_modulo)->get();
                    foreach ($PerfilModulo as $pm) {
                        PerfilModuloUsuario::where('id_perfil_modulo', $pm->id_perfil_modulo)->delete();
                    }
                    PerfilModulo::where('id_perfil_modulo', $perfil_modulo->id_perfil_modulo)->delete();
                }
            }
            if ($request->modulo) {
                foreach ($request->modulo as $key => $id_modulo) {
                    if (!PerfilModulo::where(['id_perfil' => $request->id_perfil, 'id_modulo' => $id_modulo])->exists()) {
                        $perfil_modulo = PerfilModulo::create([
                            'id_perfil' => $request->id_perfil,
                            'id_modulo' => $id_modulo
                        ]);

                        foreach ($usuarios as $key => $id_usuario) {
                            PerfilModuloUsuario::create([
                                'id_perfil_modulo', $perfil_modulo['id_perfil_modulo'],
                                'id_usuario', $id_usuario,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function traer(Request $request)
    {
        $nombre_perfil = Perfil::where('id_perfil', $request->id_perfil)->value('nombre_perfil');
        $modulos = PerfilModulo::where('id_perfil', $request->id_perfil)->pluck('id_modulo');

        return response()->json([
            'nombre' => $nombre_perfil,
            'modulos' => $modulos
        ]);
    }
}
