<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    use HasFactory;
    protected $table = 'tipo_incidencia';
    protected $primaryKey = 'id_tipo_incidencia';
    protected $fillable = [
        'nombre_tipo_incidencia',
        'orden_tipo_incidencia',
        'imagen_tipo_incidencia'
    ];
    public $timestamps = false;
}
