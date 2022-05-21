<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyecto';
    protected $primaryKey = 'id_proyecto';
    protected $fillable = [
        'id_staff',
        'id_avatar',
        'nombre_proyecto',
        'codigo_proyecto',
        'descripcion_proyecto',
        'fecha_inicio_proyecto',
        'fecha_fin_proyecto'
    ];
    public $timestamps = false;
}
