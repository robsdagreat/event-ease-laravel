<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'rating',
        'image_url',
        'capacity',
        'venue_type',
        'description',
        'amenities',
    ];

    protected $casts = [
        'amenities' => 'array',
        'rating' => 'float',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}