<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryUser extends Pivot
{
    protected $table = 'category_user';
    protected $fillable = [
        'category_id',
        'user_id',
        'percentage',
        'month'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
