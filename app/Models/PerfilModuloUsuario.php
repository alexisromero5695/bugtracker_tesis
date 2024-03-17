<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilModuloUsuario extends Model
{
    use HasFactory;
    protected $table = "perfil_modulo_usuario";
    public $timestamps = false;
    protected $fillable = [
        'id_usuario',
        'id_perfil_modulo',
        'accioncrear_perfil_modulo_usuario',
        'accioneditar_perfil_modulo_usuario',
        'accioneliminar_perfil_modulo_usuario',
        'accionaprobacion_perfil_modulo_usuario',
    ];
    protected $primaryKey = 'id_perfil_modulo_usuario';
}
