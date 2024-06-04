<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $table = "archivo";
    public $timestamps = false;
    protected $fillable = [        
        'path_archivo',
        'tamanio_archivo',
        'id_incidencia',
    ];
    protected $primaryKey = 'id_archivo';

    /*


    */
}
