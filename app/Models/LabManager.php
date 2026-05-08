<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabManager extends Model
{
    protected $table = 'lab_managers';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id'
    ];
}
