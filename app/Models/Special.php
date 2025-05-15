<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = [
        'title',
        'description',
        'venue_id',
        'venue_name',
        'start_date',
        'end_date',
        'type',
        'discount_percentage',
        'image_url',
        'is_active',
        'terms',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'terms' => 'array',
        'discount_percentage' => 'decimal:2',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}