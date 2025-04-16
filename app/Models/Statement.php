<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $table = 'statements';
    protected $fillable = [
        'user_id',
        'amount',
        'remaining_balance',
        'statementable_id',
        'statementable_type',
    ];
    public function statementable()
    {
        return $this->morphTo();
    }
}

