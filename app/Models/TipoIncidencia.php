<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIncidencia extends Model
{
    use HasFactory;
    protected $table = 'tipo';
    protected $primaryKey = 'id_tipo';
    protected $fillable = [
        'nombre_tipo',
        'orden_tipo',
        'imagen_tipo',
        'vigente_tipo'
    ];
    public $timestamps = false;
}
