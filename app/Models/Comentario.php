<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentario";
    public $timestamps = false;
    protected $fillable = [    
        'id_incidencia',
        'id_usuario',
        'detalle_comentario',
        'fecha_creacion_comentario',
    ];
    protected $primaryKey = 'id_comentario';

}
