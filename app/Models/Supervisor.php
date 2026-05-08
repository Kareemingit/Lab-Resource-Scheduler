<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisors';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id'
    ];
}
