<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'amount',
        'income_date'
    ];
}
