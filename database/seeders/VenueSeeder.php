<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = [
            [
                'name' => 'The Elements',
                'location' => 'South Jakarta',
                'rating' => 5.0,
                'image_url' => 'https://picsum.photos/id/237/400/300',
                'capacity' => 250,
                'venue_type' => 'Wedding',
                'description' => 'A luxurious venue perfect for weddings and grand celebrations.',
                'amenities' => json_encode(['Parking', 'WiFi', 'Catering', 'Sound System']),
            ],
            [
                'name' => 'Grand Ballroom Central',
                'location' => 'Central Jakarta',
                'rating' => 4.8,
                'image_url' => 'https://picsum.photos/id/238/400/300',
                'capacity' => 800,
                'venue_type' => 'Corporate Event',
                'description' => 'Ideal for large corporate events and conferences.',
                'amenities' => json_encode(['Projector', 'Stage', 'Parking', 'WiFi']),
            ],
            [
                'name' => 'Cozy Cafe Corner',
                'location' => 'West Jakarta',
                'rating' => 4.5,
                'image_url' => 'https://picsum.photos/id/239/400/300',
                'capacity' => 50,
                'venue_type' => 'Birthday Party',
                'description' => 'A small, intimate cafe for birthday parties.',
                'amenities' => json_encode(['WiFi', 'Coffee', 'Snacks']),
            ],
            [
                'name' => 'Exhibition Hall Alpha',
                'location' => 'North Jakarta',
                'rating' => 4.7,
                'image_url' => 'https://picsum.photos/id/240/400/300',
                'capacity' => 1500,
                'venue_type' => 'Exhibition',
                'description' => 'Spacious hall for major conferences and exhibitions.',
                'amenities' => json_encode(['Large Screens', 'Booths', 'Parking', 'Food Court']),
            ],
            [
                'name' => 'Riverside Garden',
                'location' => 'East Jakarta',
                'rating' => 4.9,
                'image_url' => 'https://picsum.photos/id/241/400/300',
                'capacity' => 120,
                'venue_type' => 'Social Gathering',
                'description' => 'Beautiful outdoor garden space for social events.',
                'amenities' => json_encode(['Garden', 'Outdoor Seating', 'BBQ Area']),
            ],
            [
                'name' => 'Multipurpose Hub One',
                'location' => 'Central Jakarta',
                'rating' => 4.6,
                'image_url' => 'https://picsum.photos/id/242/400/300',
                'capacity' => 300,
                'venue_type' => 'Multi-purpose',
                'description' => 'Flexible space suitable for various event types.',
                'amenities' => json_encode(['Parking', 'WiFi', 'AV Equipment', 'Kitchenette']),
            ],
            [
                'name' => 'Arena Maxima',
                'location' => 'South Jakarta',
                'rating' => 4.9,
                'image_url' => 'https://picsum.photos/id/243/400/300',
                'capacity' => 4500,
                'venue_type' => 'Concert',
                'description' => 'Large arena for concerts and major performances.',
                'amenities' => json_encode(['Stage', 'Sound System', 'Parking', 'Seating']),
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}