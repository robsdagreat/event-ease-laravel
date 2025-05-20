<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'event_type',
        'venue_id',
        'venue_name',
        'firebase_user_id',
        'organizer_name',
        'is_public',
        'expected_attendees',
        'image_url',
        'status',
        'ticket_price',
        'tags',
        'contact_email',
        'contact_phone',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_public' => 'boolean',
        'tags' => 'array',
        'ticket_price' => 'float',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type', 'name');
    }

    public function firebaseUser()
    {
        return $this->belongsTo(FirebaseUser::class, 'firebase_user_id', 'uid');
    }
}