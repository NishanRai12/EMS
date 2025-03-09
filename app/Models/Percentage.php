<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    protected $table = 'percentages';
    protected $fillable = [
        'user_id',
        'category_id',
        'percentage'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}

