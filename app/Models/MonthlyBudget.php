<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyBudget extends Model
{
    protected $table = 'monthly_budgets';
    protected $fillable = [
        'month',
        'user_id',
        'limit'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
