<?php // Code within app\Helpers\Helper.php
namespace App\Helpers;

use App\Models\Modulo;
use App\Models\PerfilModulo;
use Carbon\Carbon;

class Helper
{


    public static function dia($fecha)
    {
        $miFecha = new Carbon($fecha);
        $otroDia =  $miFecha->format('l');

        $dias_ES = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombreDia = str_replace($dias_EN, $dias_ES, $otroDia);
        return $nombreDia;
    }

    public static function mes($fecha)
    {

        $miFecha = new Carbon($fecha);

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $meses[($miFecha->format('n')) - 1];
        return $mes;
    }

    public static function DateFormat1($date)
    {

        // mié., 23 de nov. de 2022 5:07
        return  mb_substr(mb_strtolower(self::dia($date)), 0, 3) . "., " . Carbon::parse($date)->format('d') . " de " . mb_substr(mb_strtolower(self::mes($date)), 0, 3) . ". de " . Carbon::parse($date)->format('Y') . ' ' . Carbon::parse($date)->format('H:i');
    }
    public static function pluralizar($cantidad, $singular, $plural)
    {
        return $cantidad == 1 ? $singular : $plural;
    }
    public static function tiempoTranscurrido($fechaTiempo)
    {
        // Convertimos la fecha y hora a un objeto Carbon para utilizar sus métodos
        $fecha = Carbon::parse($fechaTiempo);

        // Obtenemos la fecha y hora actual
        $ahora = Carbon::now();

        // Calculamos la diferencia entre la fecha y hora actual y la fecha y hora proporcionada
        $diferencia = $fecha->diff($ahora);

        // Función auxiliar para manejar singular y plural


        // Formateamos el tiempo transcurrido

        // Formateamos el tiempo transcurrido
        if ($diferencia->y > 0) {
            return "Hace {$diferencia->y} " . self::pluralizar($diferencia->y, 'año', 'años');
        } elseif ($diferencia->m > 0) {
            return "Hace {$diferencia->m} " . self::pluralizar($diferencia->m, 'mes', 'meses');
        } elseif ($diferencia->days / 7 > 0) { // Calculamos el número de semanas
            return "Hace " . intval($diferencia->days / 7) . " " . self::pluralizar(intval($diferencia->days / 7), 'semana', 'semanas');
        } elseif ($diferencia->d > 0) {
            return "Hace {$diferencia->d} " . self::pluralizar($diferencia->d, 'día', 'días');
        } elseif ($diferencia->h > 0) {
            return "Hace {$diferencia->h} " . self::pluralizar($diferencia->h, 'hora', 'horas');
        } elseif ($diferencia->i > 0) {
            return "Hace {$diferencia->i} " . self::pluralizar($diferencia->i, 'minuto', 'minutos');
        } else {
            return "Hace {$diferencia->s} " . self::pluralizar($diferencia->s, 'segundo', 'segundos');
        }
    }

    public static function breadcrumb($id_modulo, $modulos)
    {
        $jerarquia = [];

        // Buscar el módulo actual por su ID
        $modulo_actual = null;
        foreach ($modulos as $modulo) {
            if ($modulo['id_modulo'] == $id_modulo) {
                $modulo_actual = $modulo;
                break;
            }
        }

        // Si se encuentra el módulo actual
        if ($modulo_actual) {
            // Agregar el módulo actual al arreglo de jerarquía
            $jerarquia[] = [
                'id_modulo' => $modulo_actual['id_modulo'],
                'icono_modulo' => $modulo_actual['icono_modulo'],
                'nombre_modulo' => $modulo_actual['nombre_modulo']
            ];

            // Si el módulo tiene un padre
            if ($modulo_actual->idpadre_modulo != 0) {
                // Obtener la jerarquía del padre recursivamente
                $jerarquia_padre = self::breadcrumb($modulo_actual->idpadre_modulo, $modulos);
                // Unir la jerarquía del padre con la jerarquía actual
                $jerarquia = array_merge($jerarquia_padre, $jerarquia);
            }
        }

        return $jerarquia;
    }


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
