<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'category',
        'is_special',
        'used_hours',
        'max_hours',
        'required_role',
        'maintenance_times',
        'sec_eq_id',
        'price',
        'status'
    ];
}
