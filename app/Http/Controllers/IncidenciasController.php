<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Archivo;
use App\Models\Comentario;
use App\Models\Estado;
use App\Models\Incidencia;
use App\Models\Modulo;
use App\Models\Prioridad;
use App\Models\Priority;
use App\Models\Proyecto;
use App\Models\Resolucion;
use App\Models\Staff;
use App\Models\TipoIncidencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class IncidenciasController extends Controller
{
    public function index($id_modulo, $codigo_proyecto = null)
    {
        $proyecto = [];
        if ($codigo_proyecto) {
            $proyecto = Proyecto::leftjoin('staff', 'proyecto.id_staff', 'staff.id_staff')
                ->join('avatar', 'proyecto.id_avatar', 'avatar.id_avatar')
                ->where('proyecto.codigo_proyecto', $codigo_proyecto)
                ->first();
            if (!$proyecto) {
                abort(404);
            }
        }

        $prioridades = Prioridad::orderby('orden_prioridad')->get();
        $breadcrumb = Helper::breadcrumb($id_modulo, Modulo::where('vigente_modulo', 1)->get());

        $proyectos = Proyecto::where('vigente_proyecto', 1)->get();
        $tipos_incidencia = TipoIncidencia::where('vigente_tipo', 1)->get();
        $estados = Estado::where('vigente_estado', 1)->get();
        $usuarios = Staff::where('vigente_staff', 1)->orderby('orden_staff')->get();
       
        return view('pages.incidencias', compact(
            'proyecto',
            'codigo_proyecto',
            'prioridades',
            'breadcrumb',
            'proyectos',
            'tipos_incidencia',
            'estados',
            'usuarios'
        ));
    }
    public function tabla(Request $request)
    {
        $data = [];
        $sql = "select 
                incidencia.id_incidencia,
                incidencia.numero_incidencia,
                nombre_tipo as tipo,
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
                color_prioridad,
                color_texto_prioridad,
                estado.nombre_estado as estado,
                estado.color_estado as color_estado,
                estado.color_texto_estado,
                resolucion.nombre_resolucion as resolucion,
                incidencia.fecha_creacion_incidencia,
                incidencia.fecha_actualizacion_incidencia,
                incidencia.fecha_vencimiento_incidencia,
                orden_incidencia
                from incidencia 
                inner join proyecto on proyecto.id_proyecto = incidencia.id_proyecto 
                left join staff as informante on informante.id_staff = incidencia.id_informante 
                left join color as color_informante on color_informante.id_color = informante.id_color 

                left join staff as responsable on responsable.id_staff = incidencia.id_responsable 
                left join color as color_responsable on color_responsable.id_color = responsable.id_color
                inner join estado on estado.id_estado = incidencia.id_estado 
                inner join prioridad on prioridad.id_prioridad = incidencia.id_prioridad 
                inner join tipo on tipo.id_tipo = incidencia.id_tipo 
                left join resolucion on resolucion.id_resolucion = incidencia.id_resolucion";
        if ($request->codigo_proyecto) {
            $sql .=  " where proyecto.codigo_proyecto = '$request->codigo_proyecto'";
        }

        $sql .=  " order by orden_incidencia desc";


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
            } else {
                $informante = "<div class='user-card text-nowrap'>
                                <img  style='max-width:17%' src='/images/default/sin-asignar.svg'>
                                <div class=''>
                                    <span class='tb-lead ml-2'>Sin asignar</span>
                                </div>
                            </div>";
            }
            // <img src='/files/prioridad/$value->imagen_prioridad'> 

            array_push($data,    [
                'orden' =>  $value->orden_incidencia,
                'tipo' =>  $value->tipo,
                'codigo' => "<a href='/incidencia/$value->codigo_proyecto-$value->numero_incidencia'><p class='text-nowrap'> $value->codigo_proyecto-$value->numero_incidencia</p></a>",
                'nombre' => "<a href='/incidencia/$value->codigo_proyecto-$value->numero_incidencia'><p class='text-nowrap'> $value->nombre_incidencia</p><a>",
                'responsable' =>  $responsable,
                'informante' =>  $informante,
                'prioridad' => "<span style='border-radius: 14px; background: $value->color_prioridad; color: $value->color_texto_prioridad;padding: 3px 8px;' class='text-nowrap'>$value->prioridad</span>",
                'estado' => "<span style='border-radius: 14px; background: $value->color_estado; color: $value->color_texto_estado;padding: 3px 8px;' class='text-nowrap'>$value->estado</span>",
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


    public function crearActualizar(Request $request)
    {
        $data_agregar = [];
        if (!$request->id_incidencia) { //CREA                   
       
            if ($request->proyecto) {
                $data_agregar['id_proyecto'] = $request->proyecto;
            }
            if ($request->informante) {
                $data_agregar['id_informante'] = $request->informante;
            }
            if ($request->responsable) {
                $data_agregar['id_responsable'] = $request->responsable;
                $data_agregar['fecha_asignacion_incidencia'] = Carbon::now();
            }
            $data_agregar['id_estado'] = 1;
            if ($request->tipo) {
                $data_agregar['id_tipo'] = $request->tipo;
            }
            if ($request->prioridad) {
                $data_agregar['id_prioridad'] = $request->prioridad;
            }

            if ($request->resolucion) {
                $data_editar['id_resolucion'] = $request->resolucion;
            }
         
            if ($request->nombre) {
                $data_agregar['nombre_incidencia'] = $request->nombre;
            }
            if ($request->descripcion) {
                $data_agregar['descripcion_incidencia'] = $request->descripcion;
            }
            $data_agregar['fecha_creacion_incidencia'] = Carbon::now();
            $data_agregar['fecha_actualizacion_incidencia'] = Carbon::now();

            if ($request->fecha_vencimiento) {
                $data_agregar['fecha_vencimiento_incidencia'] = Carbon::parse($request->fecha_vencimiento)->format('Y-m-d');
            }

            $numero_incidencia = Incidencia::where('id_proyecto', $request->proyecto)
                ->max('numero_incidencia');
            $data_agregar['numero_incidencia'] = $numero_incidencia + 1;
           $incidencia = Incidencia::create($data_agregar);           
        } else {

            /*
       'id_proyecto',
        'id_informante',
        'id_responsable',
        'id_estado',
        'id_prioridad',
        'id_resolucion',
        'id_sistema',
        'id_cliente',
        'nombre_incidencia',
        'descripcion_incidencia',
        'fecha_creacion_incidencia',
        'fecha_actualizacion_incidencia',
        'fecha_vencimiento_incidencia',
        'id_tipo',
        'numero_incidencia',    
            */
            $tarea_historica = Incidencia::where('id_incidencia', $request->id_incidencia)->first();

            $data_editar = [];

            if ($request->proyecto) {
                $data_editar['id_proyecto'] = $request->proyecto;
            }
            if ($request->informante) {
                $data_editar['id_informante'] = $request->informante;
            }
            if ($request->responsable) {
                $data_editar['id_responsable'] = $request->responsable;
                if($tarea_historica['id_responsable'] == null){
                    $data_agregar['fecha_asignacion_incidencia'] = Carbon::now();
                }
            }

            if ($request->estado) {
                $data_editar['id_estado'] = $request->estado;
            }
            if ($request->tipo) {
                $data_editar['id_tipo'] = $request->tipo;
            }
            if ($request->prioridad) {
                $data_editar['id_prioridad'] = $request->prioridad;
            }
            if ($request->resolucion) {
                $data_editar['id_resolucion'] = $request->resolucion;
            }
         
            if ($request->nombre) {
                $data_editar['nombre_incidencia'] = $request->nombre;
            }
            if ($request->descripcion) {
                $data_editar['descripcion_incidencia'] = $request->descripcion;
            }
            $data_agregar['fecha_actualizacion_incidencia'] = Carbon::now();


            Incidencia::where('id_incidencia', $request->id_incidencia)->update($data_editar);
            $incidencia = Incidencia::where('id_incidencia', $request->id_incidencia)->first();
            if ($request->estado == 5) {  //COMPLETADO

                // $informante = Usuario::where('id_usuario', $tarea_usuario['idusuariocreacion_tareausuario'])->first();
                // $responsable = Usuario::where('id_usuario', $tarea_usuario['idusuarioasignado_tareausuario'])->first();

                // $data = [
                //     'usuario_responsable' => "{$responsable['nombre_usuario']} {$responsable['apellidopaterno_usuario']}",
                //     'usuario_informante' => "{$informante['nombre_usuario']} {$informante['apellidopaterno_usuario']}",
                //     'glosa_tareausuario' => $tarea_usuario['glosa_tareausuario'],
                //     'glosa_area' =>  $tarea_usuario['glosa_area'],
                //     'nombre_categoriaarea' => CategoriaArea::where('id_categoriaarea', $tarea_usuario['id_categoriaarea'])->value('nombre_categoriaarea'),
                //     'dominio' => FacadesRequest::root(),
                // ];

                // if ($informante['email_usuario']) {
                //     Mail::send('plantillas-email.tarea-completada', $data, function ($message) use ($responsable, $informante, $data) {
                //         $message->from(\Config::get("constants.MAIL_FROM_ADDRESS"), "Tarea completada");
                //         $message->to($informante['email_usuario'])->subject("La tarea " . $data['glosa_tareausuario'] . " ha sido conpletada");
                //     });
                // }
            }        
        }
        return response()->json($incidencia);
    }




    /* ======================================================================================================
                                                INCIDENCIA  
    ======================================================================================================*/
    function incidencia($codigo_incidencia)
    {
        $arrCodigo = explode("-", $codigo_incidencia);
        $incidencia_ = Incidencia::join('proyecto', 'proyecto.id_proyecto', 'incidencia.id_proyecto')
            ->join('avatar', 'avatar.id_avatar', 'proyecto.id_avatar')
            ->leftjoin('estado','estado.id_estado','incidencia.id_estado')
            ->leftjoin('prioridad','prioridad.id_prioridad','incidencia.id_prioridad')
            ->leftjoin('resolucion','resolucion.id_resolucion','incidencia.id_resolucion')
            ->leftjoin('tipo','tipo.id_tipo','incidencia.id_tipo')
            ->leftjoin('cliente','cliente.id_cliente','incidencia.id_cliente')
            ->where('proyecto.codigo_proyecto', $arrCodigo[0])
            ->where('incidencia.numero_incidencia', $arrCodigo[1])
            ->first();
        if (!$incidencia_) {
            abort(404);
        }
  
        $prioridades = Prioridad::orderby('orden_prioridad')->get();
        $tipos_incidencia = TipoIncidencia::orderby('orden_tipo')->get();
        $estados = Estado::orderby('orden_estado')->get();
        $resoluciones = Resolucion::orderby('orden_resolucion')->get();

        $archivos_ = Archivo::where('id_incidencia', $incidencia_['id_incidencia'])->get();


        $archivos = [];
        foreach ($archivos_ as $key => $archivo) {
            array_push($archivos, [
                'name' => $archivo->path_archivo,
                'size' => $archivo->tamanio_archivo,
                'type' => mime_content_type(public_path("archivos/" . $archivo->path_archivo)),
                'url' =>  "/archivos/" . $archivo->path_archivo
            ]);
        }
        $archivos = json_encode($archivos, true);

        $comentarios = Comentario::where('id_incidencia', $incidencia_['id_incidencia'])->get();


        $nombre_informante = null;
        $apellido_paterno_informante = null;
        $apellido_materno_informante = null;
        if($incidencia_['id_informante']){
            $informante = Staff::where('id_staff',$incidencia_['id_informante'])->first();
            $nombre_informante = $informante['nombre_staff'];
            $apellido_paterno_informante = $informante['apellido_paterno_staff'];
            $apellido_materno_informante = $informante['apellido_materno_staff'];
        }

        $nombre_responsable = null;
        $apellido_paterno_responsable = null;
        $apellido_materno_responsable = null;
        if($incidencia_['id_responsable']){
            $responsable = Staff::where('id_staff',$incidencia_['id_responsable'])->first();
            $nombre_responsable = $responsable['nombre_staff'];
            $apellido_paterno_responsable = $responsable['apellido_paterno_staff'];
            $apellido_materno_responsable = $responsable['apellido_materno_staff'];
        }
    
        $incidencia = [
            'id_incidencia' => $incidencia_['id_incidencia'],
            'id_proyecto' => $incidencia_['id_proyecto'],

            'id_informante'=> $incidencia_['id_informante'],
            'nombre_informante'=> $nombre_informante,
            'apellido_paterno_informante'=> $apellido_paterno_informante,
            'apellido_materno_informante'=> $apellido_materno_informante,

            'id_responsable'=> $incidencia_['id_responsable'],
            'nombre_responsable'=> $nombre_responsable,
            'apellido_paterno_responsable'=> $apellido_paterno_responsable,
            'apellido_materno_responsable'=> $apellido_materno_responsable,

            'id_estado'=>$incidencia_['id_estado'],
            'nombre_estado'=>$incidencia_['nombre_estado'],
            'color_estado'=>$incidencia_['color_estado'],

            'id_prioridad'=>$incidencia_['id_prioridad'],
            'color_prioridad'=>$incidencia_['color_prioridad'],
                       
            'id_resolucion'=>$incidencia_['id_resolucion'],
            'nombre_resolucion'=>$incidencia_['nombre_resolucion'],
                     
            'id_cliente'=>$incidencia_['id_cliente'],
            'nombre_cliente'=>$incidencia_['nombre_cliente'],

            'id_tipo'=>$incidencia_['id_tipo'],
            'nombre_tipo'=>$incidencia_['nombre_tipo'],

            'nombre_incidencia'=>$incidencia_['nombre_incidencia'],
            'descripcion_incidencia'=>$incidencia_['descripcion_incidencia'],
        
            
            'fecha_asignacion_incidencia'=>$incidencia_['fecha_asignacion_incidencia'],
        
            'numero_incidencia'=>$incidencia_['numero_incidencia'],     
                    
            'nombre_proyecto'=>$incidencia_['nombre_proyecto'], 
            'codigo_proyecto'=>$incidencia_['codigo_proyecto'], 
            'descripcion_proyecto'=>$incidencia_['descripcion_proyecto'],        

            'imagen_avatar'=>$incidencia_['imagen_avatar'],        

            'fecha_vencimiento_incidencia'=>$incidencia_['fecha_vencimiento_incidencia'],

            'fecha_creacion_incidencia'=> Carbon::parse($incidencia_['fecha_creacion_incidencia'])->format('d-m-Y H:i:s'),
            'fecha_actualizacion_incidencia'=> Carbon::parse($incidencia_['fecha_actualizacion_incidencia'])->format('d-m-Y H:i:s'),
            
        ];
     
        return view('pages.incidencia', compact(
            'resoluciones',
            'estados',
            'tipos_incidencia',
            'incidencia',
            'prioridades',
            'archivos',
            'comentarios'
        ));
    }

    function crearActualizarArchivos(Request $request)
    {
        $incidencia = Incidencia::where('id_incidencia', $request->id_incidencia)->first();

        if ($request->hasFile('file')) {
            // Obtener los archivos subidos
            $files = $request->file('file');
            // Almacenar los archivos en disco
            foreach ($files as $file) {

                if (!Archivo::where('path_archivo', $file->getClientOriginalName())->where('id_incidencia', $request->id_incidencia)->exists()) {
                    $file_name = $file->getClientOriginalName();
                    $count = 1;
                    while (Archivo::where('path_archivo', 'like', $file_name . '%')->exists()) {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                        $file_name =  "$fileName($count).$extension";
                        $count++;
                    }
                    $size = $file->getSize();
                    $path_file = public_path('archivos');
                    $file->move($path_file, $file_name);
                    Archivo::create([
                        'path_archivo' => $file_name,
                        'tamanio_archivo' => $size,
                        'id_incidencia' => $incidencia['id_incidencia']
                    ]);
                }
            }
            return 'ok';
        }
    }

    function eliminarArchivo(Request $request)
    {
        $archivo =  Archivo::where('path_archivo', $request->path_archivo)->where('id_incidencia', $request->id_incidencia)->first();
        $path_file = public_path('archivos');
        $ruta = $path_file . "/" . $archivo['path_archivo'];
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        Archivo::where('id_archivo', $archivo['id_archivo'])->delete();
        return 'ok';
    }


    function ListarComentarios(Request $request)
    {
        $comentarios = Comentario::join('usuario', 'usuario.id_usuario', 'comentario.id_usuario')
            ->join('staff', 'staff.id_staff', 'usuario.id_staff')
            ->where('id_incidencia', $request->id_incidencia)
            ->select(
                'id_incidencia',
                'detalle_comentario',
                'fecha_creacion_comentario',
                'nombre_staff',
                'apellido_paterno_staff',
                'apellido_materno_staff',
                'comentario.id_usuario',
                'id_comentario'
            )
            ->orderby('fecha_creacion_comentario')
            ->get();

        $data = array();
        foreach ($comentarios as $key => $value) {
            array_push($data, [
                'id_incidencia' => $value->id_incidencia,
                'detalle_comentario' => $value->detalle_comentario,
                'fecha_creacion_comentario' => $value->fecha_creacion_comentario,
                'nombre_usuario' => $value->nombre_staff,
                'apellidopaterno_usuario' => $value->apellido_paterno_staff,
                'apellidomaterno_usuario' => $value->apellido_materno_staff,
                'id_usuario' => $value->id_usuario,
                'id_comentario' => $value->id_comentario,
                'fecha_creacion' => Helper::DateFormat1($value->fecha_creacion_comentario)
            ]);
        }

        return response()->json($data);
    }


    function crearActualizarComentario(Request $request)
    {
        if ($request->id_comentario) {
            Comentario::where('id_comentario', $request->id_comentario)
                ->update([
                    'detalle_comentario' => $request->cuerpo,
                ]);
        } else {
            Comentario::create([
                'id_incidencia' => $request->id_incidencia,
                'detalle_comentario' => $request->cuerpo,
                'fechacreacion_comentario' => Carbon::now(),
                'id_usuario' => Session::get('staff')->id_usuario
            ]);
        }
    }

    function traerComentario(Request $request)
    {
        $comentario_tarea = Comentario::where('id_comentario', $request->id_comentario)->first();
        return response()->json($comentario_tarea);
    }

    function eliminarComentario(Request $request)
    {
        Comentario::where('id_comentario', $request->id_comentario)->delete();
    }
}
