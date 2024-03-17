<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = "perfil";
    public $timestamps = false;
    protected $fillable = [        
        'nombre_perfil',
        'fecha_creacion_perfil',
        'vigente_perfil',       
    ];
    protected $primaryKey = 'id_perfil';
}
