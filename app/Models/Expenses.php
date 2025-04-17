<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'user_id',
        'category_id',
        'expenses_date',
        'amount',
        'description',
        'title'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function budget()
    {
        return $this->belongsTo(MonthlyBudget::class);
    }

    // Expense belongs to a Monthly Budget
    public function monthlyBudget()
    {

        return $this->belongsTo(MonthlyBudget::class);
    }

    public function statement()
    {
        return $this->morphOne(Statement::class, 'statementable');
    }
}
