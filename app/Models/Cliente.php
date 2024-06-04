<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    public $timestamps = false;
    protected $fillable = [        
        'nombre_cliente',
        'giro_cliente',
        'documento_cliente',
        'telefono_cliente',
        'correo_cliente',
        'direccion_cliente',
        'fecha_creacion_cliente',
        'orden_cliente',
        'sitio_web_cliente',
        'vigente_cliente',              
    ];
    protected $primaryKey = 'id_cliente';
}
