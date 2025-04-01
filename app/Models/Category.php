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
        return $this->belongsToMany(User::class)->withPivot('percentage','month');
    }
    public function user()
    {
        return $this->belongsTo(User::class); // 'user_id' is automatically assumed
    }

    public function expenses(){
        return $this->hasMany(Expenses::class);
    }
    public function percentage(){
        return $this->hasOne(Percentage::class);
    }


}
