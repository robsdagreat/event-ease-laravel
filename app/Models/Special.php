<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'establishment_name',
        'establishment_type',
        'location',
        'start_date',
        'end_date',
        'type',
        'discount_percentage',
        'image_url',
        'is_active',
        'terms',
        'contact_email',
        'contact_phone',
        'website',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'terms' => 'array',
        'discount_percentage' => 'float',
    ];
}