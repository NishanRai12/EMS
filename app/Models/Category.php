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
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('percentage','month');
    }
    public function expenses(){
        return $this->hasMany(Expenses::class);
    }
    public function percentage(){
        return $this->hasOne(Percentage::class);
    }
}
