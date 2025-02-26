<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function expenses(){
        return $this->hasMany(Expenses::class);
    }
    public function percentage(){
        return $this->hasOne(Percentage::class);
    }
}
