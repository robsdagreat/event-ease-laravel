<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            [
                'name' => 'Wedding',
                'description' => 'Celebrate your special day.',
                'image_url' => 'https://picsum.photos/id/1033/400/300',
                'icon' => 'favorite',
                'min_capacity' => 50,
                'max_capacity' => 500,
            ],
            [
                'name' => 'Corporate Event',
                'description' => 'Host professional meetings and events.',
                'image_url' => 'https://picsum.photos/id/1048/400/300',
                'icon' => 'business',
                'min_capacity' => 20,
                'max_capacity' => 1000,
            ],
            [
                'name' => 'Birthday Party',
                'description' => 'Party time! Celebrate another year.',
                'image_url' => 'https://picsum.photos/id/1058/400/300',
                'icon' => 'cake',
                'min_capacity' => 10,
                'max_capacity' => 100,
            ],
            [
                'name' => 'Concert',
                'description' => 'Large scale professional gatherings.',
                'image_url' => 'https://picsum.photos/id/1082/400/300',
                'icon' => 'music_note',
                'min_capacity' => 100,
                'max_capacity' => 5000,
            ],
            [
                'name' => 'Exhibition',
                'description' => 'Showcase your art, products, or ideas.',
                'image_url' => 'https://picsum.photos/id/1076/400/300',
                'icon' => 'museum',
                'min_capacity' => 50,
                'max_capacity' => 2000,
            ],
        ];

        foreach ($eventTypes as $eventType) {
            EventType::create($eventType);
        }
    }
}