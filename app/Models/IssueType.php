<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueType extends Model
{
    use HasFactory;
    protected $table = 'issue_type';
    protected $primaryKey = 'id';
    protected $fillable = [      
        'name',         
    ];
    public $timestamps = false;
}
