<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $hidden = ['id'];

    protected $fillable = [
        'code',
        'discount_type',
        'amount',
        'min_cart_total',
        'is_active',
        'active_from',
        'active_to'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'active_from' => 'datetime',
        'active_to' => 'datetime',
    ];
}
