<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use HasFactory;
    protected $table = 'grants';
    protected $primaryKey = 'grant_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'end_date',
        'fund',
        'financial_id',
        'project_id',
        'name'
    ];
}
