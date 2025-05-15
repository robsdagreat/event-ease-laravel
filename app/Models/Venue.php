<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'venue_type',
        'capacity',
        'rating',
        'amenities',
        'images',
        'contact_email',
        'contact_phone',
        'website',
        'pricing',
        'special_offers',
        'is_available',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'pricing' => 'array',
        'special_offers' => 'array',
        'is_available' => 'boolean',
        'rating' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function specials()
    {
        return $this->hasMany(Special::class);
    }
}