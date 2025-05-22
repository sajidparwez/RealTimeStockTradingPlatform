<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'type', 'stock_symbol', 'quantity', 'price', 'total_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
