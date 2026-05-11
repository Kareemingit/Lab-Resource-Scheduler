<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'balance',
        'state',
        'supervisor_id'
    ];
}
