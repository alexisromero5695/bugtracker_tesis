<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;

use App\Models\Modulo;
use App\Models\PerfilModulo;

class Helper
{
    public static function  ObtenerArbolMenues($matrizModulo, $padre = 0)
    {
        if ($matrizModulo) {
            $menu = [];
            foreach ($matrizModulo[$padre] as $modulo) {
                $nuevoMenu = new \stdClass();
                $nuevoMenu->url = $modulo['link_modulo'];
                $nuevoMenu->nombre = $modulo['nombre_modulo'];
                $nuevoMenu->icono = $modulo['icono_modulo'];
                $nuevoMenu->id_modulo = $modulo['id_modulo'];
                if (isset($matrizModulo[$modulo['id_modulo']])) {
                    $nuevoMenu->submenu = self::ObtenerArbolMenues($matrizModulo, $modulo['id_modulo']); //funcion anidada que se usa recursivamente
                }
                $menu[] = $nuevoMenu;
            }
            return $menu;
        }
    }

    public static function ObtenerPadre($id_submodulo)
    {
        $modulo =  Modulo::select('idpadre_modulo', 'id_modulo')->where('id_modulo', $id_submodulo)->first();
        $modulos = "";
        $modulos .= $modulo['id_modulo'];
        if (!($modulo['idpadre_modulo']  == 0)) {
            $modulos  = $modulo['idpadre_modulo'] . "-" . self::ObtenerPadre($modulo['idpadre_modulo']);
        }
        return $modulos;
    }

    public static function CargarMenu($id_perfil = 0)
    {
        if ($id_perfil > 0) {
            $submodulos = PerfilModulo::join('modulo', 'modulo.id_modulo', '=', 'perfil_modulo.id_modulo')
                ->where('perfil_modulo.id_perfil', $id_perfil)
                ->where('modulo.vigente_modulo', 1)
                ->select('perfil_modulo.id_modulo')
                ->get();
        } else {
            $submodulos = Modulo::select('*')
                ->where('vigente_modulo', 1)
                ->orderBy('orden_modulo')
                ->get();
        }


        $menu = "";
        if ($submodulos) {
            $modulosPadre = [];
            foreach ($submodulos as $sm) {
                $modulos = explode("-", self::ObtenerPadre($sm->id_modulo));
                for ($i = 0; $i < count($modulos); $i++) {
                    array_push($modulosPadre, $modulos[$i]);
                }
                array_push($modulosPadre, $sm->id_modulo);
            }
            $matrizModulo = [];
            $modulos = Modulo::select('*')
                ->whereIn('id_modulo', $modulosPadre)
                ->orderBy('orden_modulo')
                ->get();
            foreach ($modulos as $modulo) {
                $matrizModulo[$modulo->idpadre_modulo][] = $modulo;
            }
            $menuDinamico = static::ObtenerArbolMenues($matrizModulo);
            $menu = ["menu" => $menuDinamico];
            return json_encode($menu);
        } else {
            $menu = [];
            return json_encode($menu);
        }
    }
}
