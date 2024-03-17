<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = "staff";
    public $timestamps = false;
    protected $fillable = [
        'id_color',
        'nombre_staff',
        'apellido_paterno_staff',
        'apellido_materno_staff',
        'documento_staff',
        'puesto',
        'departamento',
        'empresa',
        'direccion_staff',
        'telefono_staff',
        'vigente_staff',
        'orden_staff'
    ];
    protected $primaryKey = 'id_staff';
    protected $appends = ['nombre_completo'];
    public function getNombreCompletoAttribute()
    {
        return $this->nombre_staff . ' ' . $this->apellido_paterno_staff;
    }
}
