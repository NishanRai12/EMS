<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';
    protected $fillable = [
        'user_id',
        'amount',
        'income_date'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
//    public function statements(){
//        return $this->morphMany(Statement::class, 'statementable');
//    }
    public function statement()
    {
        return $this->morphOne(Statement::class, 'statementable');
    }
}
