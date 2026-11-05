<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'total_price',
        'status',
    ];

    // Order တစ်ခုမှာ Order Items များစွာ ပါဝင်နိုင်ခြင်း
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order တစ်ခုမှာ Payment တစ်ခု ပါဝင်ခြင်း
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}