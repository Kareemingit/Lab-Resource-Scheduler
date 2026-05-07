<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user_infos';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'name',
        'role'
    ];
}
