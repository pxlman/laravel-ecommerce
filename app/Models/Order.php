<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'status', 'payer_id', 'cart'];
    protected $casts = [
        'cart' => 'array',
    ];
}