<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    public $timestamps = false;

    protected $fillable = [
        'eq_id',
        'researcher_id',
        'start_date',
        'end_date',
        'status',
        'res_hours'
    ];
}
