<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $table = 'grants';
    protected $primaryKey = 'grant_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'end_date',
        'fund',
        'project_id',
        'financial_id'
    ];
}
