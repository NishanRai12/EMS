<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected  $fillable = [
        'name',
        'user_id'
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function percentages()
    {
        return $this->hasMany(Percentage::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
