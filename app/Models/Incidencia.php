<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $table = 'incidencia';
    protected $primaryKey = 'id_incidencia';
    protected $fillable = [      
        'id_proyecto',
        'id_informante',
        'id_responsable',
        'id_estado_incidencia',
        'id_prioridad',
        'id_resolucion',
        'nombre_incidencia',
        'descripcion_incidencia',
        'fecha_creacion_incidencia',
        'fecha_actualizacion_incidencia',
        'fecha_vencimiento_incidencia',
        'id_tipo_incidencia',
        'numero_incidencia',
            
    ];
    public $timestamps = false;
}
