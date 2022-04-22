<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $table = 'issue';
    protected $primaryKey = 'id';
    protected $fillable = [      
        'project_id',
        'number',
        'reporter_id',
        'handler_id',
        'issue_state_id',
        'priority_id',
        'resolution_id',
        'issue_type_id',
        'title',
        'description',
        'creation_date',
        'last_update',
        'expiration_date',        
    ];
    public $timestamps = false;
}
