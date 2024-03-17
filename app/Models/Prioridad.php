<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    use HasFactory;
    protected $table = 'prioridad';
    protected $primaryKey = 'id_prioridad';
    protected $fillable = [  
        'nombre_prioridad',
        'orden_prioridad',
        'imagen_prioridad',        
    ];
    public $timestamps = false;
}
