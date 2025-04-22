<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'location',
        'image_url',
        'original_price',
        'discounted_price',
        'valid_until',
        'is_active',
        'description',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];
}