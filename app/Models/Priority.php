<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $table = 'priority';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'order',
        'path',
    ];
    public $timestamps = false;
}
