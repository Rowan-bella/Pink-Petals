<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image', // 👈 ဤနေရာတွင် 'image' ကို ထည့်ပေးရန် မမေ့ပါနှင့်
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}