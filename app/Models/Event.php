<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id',
        'event_type_id',
        'name',
        'description',
        'image_url',
        'date',
        'capacity',
        'is_approved',
        'host_type',
        'is_public',
        'host_name',
        'host_contact',
        'host_description',
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_approved' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}