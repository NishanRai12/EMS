<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'title'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function budget(){
        return $this->belongsTo(MonthlyBudget::class);
    }

    // Expense belongs to a Monthly Budget
    public function monthlyBudget(){

        return $this->belongsTo(MonthlyBudget::class);
    }
    public function statements(){
        return $this->morphMany(Statement::class, 'statementable');
    }
}
