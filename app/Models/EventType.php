<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'min_capacity',
        'max_capacity',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
