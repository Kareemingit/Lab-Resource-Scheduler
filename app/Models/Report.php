<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'description',
        'eq_id',
        'lab_man_id',
        'researcher_id'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'eq_id', 'eq_id');
    }
}
