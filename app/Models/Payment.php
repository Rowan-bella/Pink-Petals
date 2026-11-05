<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_slip',
        'status',
    ];

    /**
     * Order နှင့် ချိတ်ဆက်ခြင်း (One-to-One / Many-to-One)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}