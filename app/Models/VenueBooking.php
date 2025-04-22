<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id',
        'start_time',
        'end_time',
        'expected_guests',
        'purpose',
        'contact_name',
        'contact_email',
        'contact_phone',
        'is_approved',
        'special_requests',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}