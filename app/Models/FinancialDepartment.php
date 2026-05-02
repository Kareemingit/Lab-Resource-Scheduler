<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialDepartment extends Model
{
    protected $table = 'financial_departments';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'budget'
    ];
}
