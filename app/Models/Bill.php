<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $primaryKey = 'bill_id';
    protected $table = 'bills';
    public $timestamps = false;
    protected $fillable = [
        'bill_id',
        'grant_id',
        'project_id',
        'user_id',
        'billed',
    ];
}
