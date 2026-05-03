<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialDepartment extends Model
{
    protected $table = 'financial_departments';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'budget'
    ];
}
