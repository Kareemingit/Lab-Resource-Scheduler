<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
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
