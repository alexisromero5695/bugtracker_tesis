<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id',
        'avatar_id',
        'title',
        'code',
        'description',
        'start_date',
        'end_date',
    ];
    public $timestamps = false;
}
