<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resolucion extends Model
{
    use HasFactory;
    protected $table = 'resolucion';
    protected $primaryKey = 'id_resolucion';
    protected $fillable = [
        'nombre_resolucion',
        'orden_resolucion',    
        'descripcion_resolucion',      
    ];
    public $timestamps = false;
}
