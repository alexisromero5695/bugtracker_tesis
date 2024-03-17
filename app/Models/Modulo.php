<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = "modulo";
    public $timestamps = false;
    protected $fillable = [   
        'nombre_modulo',
        'icono_modulo',
        'link_modulo',
        'tipoaccion_modulo',
        'idpadre_modulo',
        'orden_modulo',
        'vigente_modulo',        
    ];
    protected $primaryKey = 'id_modulo';
}
