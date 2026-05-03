<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'certifications';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'eq_id'
    ];
}
